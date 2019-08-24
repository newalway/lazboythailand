<?php

namespace ProjectBundle\Utils;

use ProjectBundle\Entity\Authentication;
use ProjectBundle\Entity\AccessToken;
use ProjectBundle\Entity\RefreshToken;
use ProjectBundle\Entity\SettingOption;
use ProjectBundle\Entity\CustomerPaymentEpayment;
use ProjectBundle\Entity\CustomerOrder;
use ProjectBundle\Entity\BankAccount;
use ProjectBundle\Entity\CustomerPaymentOmise;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;

use Exception;
use GuzzleHttp\Client;
use phpbrowscap\Browscap;
use GeoIp2\Database\Reader;

class Omise
{
	private $kernel;
	private $factory;
	private $mailer;
	private $router;

	private $util;
	private $live_mode;
	private $payment_data;

	public function __construct($kernel, $factory, \Swift_Mailer $mailer, Router $router)
	{
		$this->container = $kernel->getContainer();
		$this->factory = $factory;
		$this->mailer = $mailer;
		$this->router = $router;

		$this->util = $this->container->get('utilities');
		$this->live_mode = $this->getLiveMode();
		$this->payment_data = array();
	}

	public function getOmisePublicKey()
	{
		$public_key = $this->util->getAuthenticationValue('omise_public_key');
		return $public_key;
	}
	public function getOmiseSecretKey()
	{
		$secret_key = $this->util->getAuthenticationValue('omise_secret_key');
		return $secret_key;
	}

	public function getOmisePublicAuth()
	{
		$public_key = $this->getOmisePublicKey();
		#Authentication to Omise API is done via HTTP Basic Auth with your key as user name. Password is not required.
		return 'Basic '.base64_encode($public_key.":".'');
	}
	public function getOmiseSecretAuth()
    {
		$secret_key = $this->getOmiseSecretKey();
        return 'Basic '.base64_encode($secret_key.':');
    }

	public function getOmiseTokenUri($token_id = null)
	{
		$sub_uri='';
		if($token_id){
			$sub_uri='/'.$token_id;
		}
		return $this->container->getParameter('omise_vault_uri').'tokens'.$sub_uri;
	}

	public function omiseRetriveCardByToken($omise_token)
	{
		$pAuth = $this->getOmisePublicAuth();

		//retrive a token
		$omise_vault_uri_token = $this->getOmiseTokenUri($omise_token);

		$response = $this->callOmise('GET', $omise_vault_uri_token, $pAuth);
		//retrieve response
		$response_card = json_decode($response->getBody(), true);

		return $response_card;
	}

	public function callOmise($method, $uri, $auth, $postData = null)
	{
		$client = new Client();
		try{
			return $client->request(
		         $method,
		         $uri,
		         [
					'headers' => [
						'Content-Type' => 'application/x-www-form-urlencoded',
						'Accept' => 'application/json',
						'Authorization' => $auth
					],
					'body' => $postData //,'debug' => true
		         ]
			);
		}catch (Exception $e){
			return $e->getResponse();
		}
	}

	public function omiseChargeByToken($omise_token, $arr_cart_data_summary, $order_number, $omise_return_uri=false)
	{
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();

		//get omise secretAuth
		$secretAuth = $this->getOmiseSecretAuth();

		//The charge has been authorized with 3-D Secure
		$return_uri = ($omise_return_uri) ? '&return_uri='.$omise_return_uri : '';

		//Charge a card using a token
		$data = 'amount='.$arr_cart_data_summary['total'].'00&currency=THB&card='.$omise_token.'&description='.$order_number.$return_uri;
		$omise_api_uri_charge = $this->getOmiseChargeUri();

		$response_charge = $this->callOmise('POST', $omise_api_uri_charge, $secretAuth, $data);
		$response_charge_parts = json_decode($response_charge->getBody(), true);

		return $response_charge_parts;
	}

	public function omise3DChargeValidate($response_charge_parts)
	{
		$str_return = true;
		if((isset($response_charge_parts['object']))){
			if($response_charge_parts['object']=="error"){
				$str_return = false;
			}
		}
		return $str_return;
	}

	public function omiseGetAuthorizeUri3ds($response)
	{
		return $response['authorize_uri'];
	}

	public function omiseIs3dsEnable()
	{
		 $is_3ds_secure = $this->getOmise3Ds();
		 return $is_3ds_secure;
	}

	public function omiseGetReturnUri3ds($order_number)
	{
		return $this->container->get('router')->generate('omise_3ds_order_complete', array('order_number' => $order_number),  UrlGeneratorInterface::ABSOLUTE_URL);
	}

	public function getOmiseChargeUri($token_id = null)
	{
		$sub_uri = ($token_id) ? '/'.$token_id : '' ;
		return $this->container->getParameter('omise_api_uri').'charges'.$sub_uri;
	}

	public function omiseChargeAuthorized($response_charge_parts)
	{
		$res_authorized = (isset($response_charge_parts['authorized'])) ? $response_charge_parts['authorized'] : false;
		$res_paid = (isset($response_charge_parts['paid'])) ? $response_charge_parts['paid'] : false ;
		if($res_authorized && $res_paid){
			//the charge succeeded
			return true;
		}else{
			//the charge failed
			return false;
		}
	}

	public function omiseProcessChargeSucceeded($customer_order)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		$session = $request->getSession();
		$customerPaymentOmise = $em->getRepository(CustomerPaymentOmise::class)->findOneByCustomerOrder($customer_order);
		if($customerPaymentOmise){
			// successfully
			$customer_order->setPaid(1);
			$em->flush();

			// $payment_status_paid = $this->container->getParameter('payment_status_paid');
			// $customerPaymentOmise->setStatus($payment_status_paid);

			return $customerPaymentOmise;
		}else{
			return false;
		}
	}

	public function omiseProcessChargeFailed($customer_order)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		if($customer_order){
			$customer_order->setPaid(0);
			$customer_order->setFailed(1);
			$em->flush();
		}
	}

	public function omiseRetriveChargeByToken($omise_token)
	{
		//get omise secretAuth
		$secretAuth = $this->getOmiseSecretAuth();
		//retrive a charge
		$omise_api_uri_charge = $this->getOmiseChargeUri($omise_token);
		$response = $this->callOmise('GET', $omise_api_uri_charge, $secretAuth);
		$response_charge = json_decode($response->getBody(), true);
		return $response_charge;
	}

	public function chkIsAuth()
	{
		$is_authenticated = $this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY');
		return $is_authenticated;
	}

	public function getLiveMode()
	{
		return filter_var($this->util->getAuthenticationValue('omise_livemode'), FILTER_VALIDATE_BOOLEAN);
	}
	public function getOmise3Ds()
	{
		return filter_var($this->util->getAuthenticationValue('omise_3ds'), FILTER_VALIDATE_BOOLEAN);
	}

	public function setOmiseError($message)
	{
		$session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
		$session->getFlashBag()->add('omise_errors', $message);
	}
}
