<?php

namespace ProjectBundle\Utils;

use ProjectBundle\Entity\Authentication;
use ProjectBundle\Entity\AccessToken;
use ProjectBundle\Entity\RefreshToken;
use ProjectBundle\Entity\SettingOption;
use ProjectBundle\Entity\CustomerPaymentEpayment;
use ProjectBundle\Entity\BankAccount;
use ProjectBundle\Entity\Review;
use ProjectBundle\Entity\ReviewRating;
use ProjectBundle\Entity\ReviewSetting;
use ProjectBundle\Entity\CustomerPaymentOmise;
use ProjectBundle\Entity\News;
use ProjectBundle\Entity\NewsCategory;
use ProjectBundle\Entity\InspirationCategory;

use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Intl\Locale;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Exception\NotValidCurrentPageException;

use Exception;
use GuzzleHttp\Client;
use phpbrowscap\Browscap;
use GeoIp2\Database\Reader;

class Utilities
{
	private $kernel;
	private $factory;
	private $mailer;
	private $router;
	private $translator;
	private $product_category_selected_id;

	public function __construct($kernel, $factory, \Swift_Mailer $mailer, Router $router, TranslatorInterface $translator)
	{
		$this->container = $kernel->getContainer();
		$this->factory = $factory;
		$this->mailer = $mailer;
		$this->router = $router;
		$this->translator = $translator;
	}

	/* Start Token method */
	public function destroySessionAfterLogin($request)
	{
		$session = $request->getSession();
		//remove session here
		$session->remove('token');
	}

	public function destroySessionAfterLogout($request)
	{
		$product_util = $this->container->get('app.product');
		$session = $request->getSession();

		$session_cart = $product_util->getCartSession();
		$cart_products = null;
		if(isset($session_cart['products'])){
			$cart_products['products'] = $session_cart['products'];
		}

		//remove session
		$session->remove('token');

		//remove session cart
		$product_util->removeCartSession();
		//keep session cart.products
		if($cart_products){
			$product_util->setCartSession($cart_products);
		}
	}
	public function setCookieUser()
	{
		// cookie validation
	$request = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();
		$session_id = $session->getId();
		$time_cookie = strtotime($this->container->getParameter('set_time_cookie_user_anonymously_limit'));
		$value = $this->getCookieUser();
	if(!isset($value)){
	  // update set cookie
	  $cookie = new Cookie('user_session', $session_id, $time_cookie );
	  $response = new Response();
	  $response->headers->setCookie($cookie);
	  $response->send();
	}
  }
	public function getCookieUser()
	{
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$value = $request->cookies->get('user_session');
		return $value;
	}

	public function getAccessToken()
	{
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();
		$token = $session->get('token');

		if(empty($token["access"])){
			$token = $this->getAccessTokenFromDB();
    	}

		return $token["access"];
	}

	public function getAccessTokenAfterLogin()
	{
		$token = $this->getAccessTokenFromDB();
		return $token["access"];
	}

	public function getAccessTokenFromDB()
	{
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();
		$token = Array("access"=>null, "refresh"=>null);

		$data_access_token = $this->getAccessTokenByUser();
		$data_refresh_token = $this->getRefreshTokenByUser();

		if( !($data_access_token)){
			throw new \Exception('AccessToken doesn\'t exist');
		}
		if( !($data_refresh_token)){
			throw new \Exception('RefreshToken doesn\'t exist');
		}

		$is_expires = false;
		$timestamp = time();

		$access_token = $data_access_token->getToken();
		$acctoken_expires_at = $data_access_token->getExpiresAt();
		$refresh_token = $data_refresh_token->getToken();

		if($acctoken_expires_at<$timestamp){
			$is_expires = true;
		}
		$token["access"] = $access_token;
		$token["refresh"] = $refresh_token;

		//set sesstion
		$session->set('token', $token);

		if($is_expires){
			//token expire call refreshToken
			$token = $this->refreshToken();
		}

		return $token;
	}

	public function refreshToken()
	{
		$token = Array();
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();
		$token = $session->get('token');

		if(!empty($token["refresh"])){
			$response = $this->call('GET', $this->container->getparameter('oauth2_token_endpoint').'?client_id='.$this->container->getParameter('oauth2_client_id').'&client_secret='.$this->container->getParameter('oauth2_client_secret').'&grant_type=refresh_token&refresh_token='.$token["refresh"]);
			$responseParts = json_decode($response->getBody(), true);

			unset($token["access"]);
			unset($token["refresh"]);
			$token["access"] = $responseParts['access_token'];
			$token["refresh"] = $responseParts['refresh_token'];
			//set session
			$session->set('token', $token);
		}
		return $token;
	}

	public function getAccessTokenByUser()
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		$data = $em->getRepository(AccessToken::class)->findOneBy(
			array('user'=>$user), array('id' => 'DESC')
		);
		return $data;
		//return $data = TokenQuery::create()->orderById('DESC')->setLimit(2)->findByUser($user);
	}

	public function getRefreshTokenByUser()
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$user = $this->container->get('security.token_storage')->getToken()->getUser();
		$data = $em->getRepository(RefreshToken::class)->findOneBy(
			array('user'=>$user), array('id' => 'DESC')
		);
		return $data;
	}

	public function getBaseUrlWithApiVersion()
	{
		$request = $this->container->get('request_stack')->getCurrentRequest();
		//use http
		$shceme_http = $request->getSchemeAndHttpHost();
    	$shceme_http = str_replace("https://", "http://", $shceme_http);
		$api_uri = '/api/v1/';
    	$base_uri = $shceme_http.$this->container->get('router')->getContext()->getBaseUrl().$api_uri;
		return $base_uri;
	}

	public function getBaseUrl()
	{
		$request = $this->container->get('request_stack')->getCurrentRequest();
		//use http
		$shceme_http = $request->getSchemeAndHttpHost();
    	$shceme_http = str_replace("https://", "http://", $shceme_http);
    	$base_uri = $shceme_http.$this->container->get('router')->getContext()->getBaseUrl();
		return $base_uri;
	}

	public function call($method, $uri, $auth = null, $postData = null, $base_url=true)
	{
		//$client = new Client(['verify' => false]); //disable SSL certification verification
		if($base_url){
			$base_uri = $this->getBaseUrlWithApiVersion();
		}else{
			$base_uri = $this->getBaseUrl();
		}

		//set default base_uri
		// $client = new Client(['base_uri' => $base_uri]);
		$client = new Client();
		try{
			return $client->request(
		         $method,
		         $base_uri.$uri, //after set default base_uri in construct. can start with "/" to webroot such as "/oauth/v2/token?.."
		         [
		             'headers' => [
		                 'Content-Type' => 'application/x-www-form-urlencoded',
		                 'Accept' => 'application/json',
		                 'Authorization' => 'Bearer '.$auth
		             ],
		             'body' => $postData, //'debug' => true,
								 'verify' => false
		         ]
			);
		}catch (Exception $e){

			$err_code = $e->getCode();

			//check current user exist in db.
			$data = $this->getAccessTokenByUser();
			if(!($data)){
				//no access token in db. create new token. go to change password
				throw new AccessDeniedHttpException('No access token. change your password.');
			}

			if($e->getCode() == 401){
				//token is expire
				//token is invalid

				//return $e->getResponse();
				//refresh token
				$token = $this->refreshToken();
				$access_token = $token["access"];
				//try call action again
				return $this->call($method, $uri, $access_token, $postData);

			}elseif($e->getCode() == 400){
				//refresh token is expire
				throw new AccessDeniedHttpException('Refresh token has expired.');
			}else{
				throw new AccessDeniedHttpException($err_code);
			}
		}
	}

	public function setAccessToken($username=null, $plainpassword=null, $scope=null)
	{
		$scope_query = ($scope) ? $scope : 'user' ;
		$plainpassword = ($plainpassword) ? rawurlencode($plainpassword) : null ;
    	$response = $this->call('GET', $this->container->getparameter('oauth2_token_endpoint').'?client_id='.$this->container->getParameter('oauth2_client_id').'&client_secret='.$this->container->getParameter('oauth2_client_secret').'&grant_type=password&username='.$username.'&password='.$plainpassword.'&scope='.$scope_query, null, null, false);
	}

	public function deleteAccessAndRefreshToken($user)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		//$access_tokens = $em->getRepository(AccessToken::class)->findBy(array('user'=>$user));
		$access_tokens = $em->getRepository(AccessToken::class)->findByUser($user);
		if($access_tokens){
			foreach ($access_tokens as $access_token) {
				$em->remove($access_token);
			}
			$em->flush();
		}
		$refresh_tokens = $em->getRepository(RefreshToken::class)->findBy(array('user'=>$user));
		if($refresh_tokens){
			foreach ($refresh_tokens as $refresh_token) {
				$em->remove($refresh_token);
			}
			$em->flush();
		}
	}
	/* End Token method */

	/* Start paginate method */
	public function setBackToUrl($back_to_url_name=false)
	{
		$back_to_url = Array();
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();
		$url = $this->router->generate($request->get('_route'), array_merge($request->query->all(), $request->attributes->get('_route_params')));

	    if(!$back_to_url_name){
	      $back_to_url_name = $request->get('_route');
	    }

		$back_to_url = $session->get('back_to_url');
		unset($back_to_url[$back_to_url_name]);

		$back_to_url[$back_to_url_name] = $url;
		$session->set('back_to_url', $back_to_url);
	}

	public function getBackToUrl($name)
	{
	    $request = $this->container->get('request_stack')->getCurrentRequest();
	    $session = $request->getSession();
	    $arr = $session->get('back_to_url');
	    return (isset($arr[$name])) ?  $arr[$name] : $this->router->generate($name);
	}

	public function setPaginatedOnPagerfanta($ob_query, $int_max_per_page=false)
	{
	    $request = $this->container->get('request_stack')->getCurrentRequest();
		$int_max_per_page = (!$int_max_per_page) ? $this->container->getParameter('admin_max_per_page') : $int_max_per_page;

	    $adapter = new DoctrineORMAdapter($ob_query);
		$paginated = new Pagerfanta($adapter);
	    $paginated->setMaxPerPage($int_max_per_page);
		if($page = $request->query->get('page')){
			try{
				$paginated->setCurrentPage($page);
			}
			catch(\Exception $e){
				$paginated->setCurrentPage(1);
				//$page = $page -1;
				//return $this->redirect($this->generateUrl($request->get('_route'),array_merge($request->query->all(), array_merge($request->attributes->get('_route_params'), array('page' => $page)))));
			}
		}
		return $paginated;
	}
	/* End paginate method */

	public function setCkAuthorized()
	{
		// cookie validation
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$time_cookie = $this->container->getParameter('set_time_cookie_limit');
		$value = $request->cookies->get('ck_IsAuthorized');
		if(!isset($value)){
			// update set cookie
			$cookie = new Cookie('ck_IsAuthorized', 1, time() + $time_cookie );
			$response = new Response();
			$response->headers->setCookie($cookie);
			$response->send();
		}
	}

	public function prepare_query_data($request)
	{
		$arr_data = $request->query->get('search_data');
		$arr_query_data['q'] = trim($arr_data['q']);
		return $arr_query_data;
	}

	public function getChildrenInspirationCategoryByCategoryId($arr_product_search)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$cateogry_repo = $em->getRepository(InspirationCategory::class);
		$data_cat_id = array();
		if(isset($arr_product_search['category_id']) && $arr_product_search['category_id']){
			foreach ($arr_product_search['category_id'] as $key => $category_id) {
				$arr_cat_id = array();
				$pr_category = $cateogry_repo->find($category_id);
				$children = $cateogry_repo->children($pr_category, false, null, 'asc', true);
				foreach ($children as $chi) {
					$arr_cat_id[] = $chi->getId();
				}
				$data_cat_id = array_merge($data_cat_id, $arr_cat_id);
			}
			$data_cat_id = array_unique($data_cat_id);
		}
		return $data_cat_id;
	}

	public function getRedirectUriSaveBtn($form, $data, $router_index, $router_add, $router_edit=false)
	{
		$redirect_uri = $this->getBackToUrl($router_index);
		if($router_edit){
			if($form->get('save_and_edit')->isClicked()){
				$redirect_uri = $this->router->generate($router_edit,array('id'=>$data->getId()));
			}elseif($form->get('save_and_add')->isClicked()){
				$redirect_uri = $this->router->generate($router_add);
			}
		}else{
			if($form->get('save_and_add')->isClicked()){
				$redirect_uri = $this->router->generate($router_add);
			}
		}
		return $redirect_uri;
	}

	public function setCreateNotice()
	{
		$session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
		$session->getFlashBag()->add('notice', 'Data create succeeded');
	}

	public function setUpdateNotice()
	{
		$session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
		$session->getFlashBag()->add('notice', 'Your changes were saved');
	}

	public function setRemoveNotice()
	{
		$session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
		$session->getFlashBag()->add('notice', 'Data deleted');
	}

	public function setCustomeFlashMessage($type='notice', $msg='')
	{
		$session = $this->container->get('request_stack')->getCurrentRequest()->getSession();
		$session->getFlashBag()->add($type, $msg);
	}

	public function getFilesInfo($file_name='')
	{
		$arr_data = array('file_size'=>'','file_name'=>'');
		if($file_name){
			$file_name = urldecode($file_name);
			$webRoot = $this->container->getParameter('web_path');
			if(file_exists($webRoot.$file_name)){
				$filesize_byte = filesize($webRoot.$file_name);
				$arr_data['file_size'] = $filesize_kb = round(($filesize_byte/1024), 1);
				$arr_data['file_name'] = basename($file_name);
			}
		}
		return $arr_data;
	}

	public function getFilesInFolder()
	{
		// echo $webRoot = $this->get('kernel')->getRootDir() . '/../web';
		// echo '<br/>';
		// $webRoot = $request->server->get('DOCUMENT_ROOT');
    	//
		// $finder = new Finder();
		// $finder->files()->in($webRoot);
		// foreach ($finder as $file) {
		// 	// Dump the absolute path
	  	//   // var_dump($file->getRealPath());
    	//
	  	//   // Dump the relative path to the file, omitting the filename
	  	//   // var_dump($file->getRelativePath());
    	//
	  	//   // Dump the relative path to the file
	  	//   // var_dump($file->getRelativePathname());
		// }
	}

	// public function getBrowserCap()
	// {
	// 	$cache_dir = $this->container->getParameter('browscapcache_path');
	// 	$bc = new Browscap($cache_dir);
	// 	$current_browser = $bc->getBrowser();
	// 	return $current_browser;
	// }
	public function getBrowserCap()
	{
		$browser = get_browser(null, true);
		return $browser;
	}


	public function getGeoLite2City()
	{
		$ip_address = @$_SERVER['REMOTE_ADDR'];
		// $ip_address = '128.101.101.101'; //debug
		// $ip_address = '125.25.123.235'; //debug

		if( !(in_array($ip_address, ['127.0.0.1', '::1'], true)) ){
			$geoip_dir = $this->container->getParameter('geoip_path') . '/GeoLite2-City.mmdb';
			if(file_exists($geoip_dir)){
				$reader = new Reader($geoip_dir);
				$record = $reader->city($ip_address);
			}
		}else{
			//localhost
			$record = false;
		}
		return $record;
	}

	public function get_vimeo_oembed_endpoint()
	{
		return 'https://vimeo.com/api/oembed';
	}

	public function vimeo_json_url($video_url, $parameter=false)
	{
		$json_url = $this->get_vimeo_oembed_endpoint() . '.json?url=' . rawurlencode($video_url);
		if($parameter){
			$json_url .= $parameter;
		}
		return $json_url;
	}

	public function vimeo_xml_url($video_url, $parameter=false)
	{
		$xml_url = $this->get_vimeo_oembed_endpoint() . '.xml?url=' . rawurlencode($video_url);
		if($parameter){
			$xml_url .= $parameter;
		}
		return $xml_url;
	}

	public function videoType($url) {
	    if (strpos($url, 'youtube') > 0) {
	        return 'youtube';
	    } elseif (strpos($url, 'vimeo') > 0) {
	        return 'vimeo';
	    } else {
	        return 'unknown';
	    }
	}

	public function get_youtube_oembed_endpoint()
	{
		return 'https://www.youtube.com/oembed';
	}

	public function youtube_json_url($video_url, $parameter=false)
	{
		$json_url = $this->get_youtube_oembed_endpoint() . '?url=' . rawurlencode($video_url) . '&format=json';
		if($parameter){
			$json_url .= $parameter;
		}
		return $json_url;
	}

	public function youtube_video_id($url)
    {
      	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
  		return $matches[1];
    }

	public function removeStringDataType($subject, $search='number:')
	{
		if($subject){
			$id = str_replace($search, '', $subject);
			return $id;
		}else{
			return false;
		}
	}

	public function curl_get($url)
	{
		//Curl helper function
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		$return = curl_exec($curl);
		curl_close($curl);
		return $return;
	}

	public function getOmisePublicKey()
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$pkey = null;
		$auth_omise_pkey = $em->getRepository(Authentication::class)->findOneBy(array('name'=>'omise_public_key'), array('id' => 'DESC'));
		if($auth_omise_pkey){
			$pkey = $auth_omise_pkey->getValue();
		}
		return $pkey;
	}

	public function getGoogleMapsApiKey()
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$google_maps_api_key = null;
		$google_maps_api = $em->getRepository(Authentication::class)->findOneBy(array('name'=>'google_maps_api_key'), array('id' => 'DESC'));
		if($google_maps_api){
            $google_maps_api_key = $google_maps_api->getValue();
        }
		return $google_maps_api_key;
	}

	public function getGeolocationApiKey()
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$geolocation_api_key = null;
		$geolocation_api = $em->getRepository(Authentication::class)->findOneBy(['name'=>'geolocation_api_key']);
        if($geolocation_api){
            $geolocation_api_key = $geolocation_api->getValue();
        }
		return $geolocation_api_key;
	}

	public function getDirectionsApiKey()
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$directions_api_key = null;
		$directions_api = $em->getRepository(Authentication::class)->findOneBy(['name'=>'directions_api_key']);
        if($directions_api){
            $directions_api_key = $directions_api->getValue();
        }
		return $directions_api_key;
	}

	public function publicCacheImage($image_path, $filter='img_product_medium')
	{
		$imageManager = $this->container->get('liip_imagine.controller');
		$cacheManager = $this->container->get('liip_imagine.cache.manager');
		// $web_path = $this->container->getParameter('web_path');

		// RedirectResponse object
		$imagemanagerResponse = $imageManager->filterAction(
			new Request(),    // http request
			$image_path,      // original image you want to apply a filter to
			$filter           // filter defined in config.yml
		);

		// string to put directly in the "src" of the tag <img>
		$srcPath = $cacheManager->getBrowserPath($image_path, $filter);
		return $srcPath;
	}

	public function removeHttp($url)
	{
		// This removes either http: or https:
		$url = preg_replace("(^https?:)", "", $url );
		return $url;
	}

	public function getFormErrorMessage($form)
    {
        $errors = array();
        if($form){
            foreach ($form as $fieldName => $formField) {
                foreach ($formField->getErrors(true) as $error) {
                    $errors[$fieldName] = $error->getMessage();
                }
            }
        }
        return $errors;
    }

	public function explodeStrToArrayEmail($email)
	{
		$arr_mail=array();
		if($email){
			$arr_mail=explode(",", $email);
			$arr_mail=array_map('trim',$arr_mail);
		}
		return $arr_mail;
	}

	public function sendMailOrderConfirm($arr_cart_data, $order, $user, $mailtype)
    {
		$templating = $this->container->get('templating');
		$em = $this->container->get('doctrine')->getEntityManager();
		$repository = $em->getRepository(SettingOption::class);
		$client_protocal = $this->getClientProtocal();

		$bankAccount = $em->getRepository(BankAccount::Class)->findAllActiveData()->getQuery()->getResult();
		// $payment_omise = $this->container->get('doctrine')->getRepository(CustomerPaymentOmise::class)->findOneByCustomerOrder($order);
		// $epayment = $this->container->get('doctrine')->getRepository(CustomerPaymentEpayment::class)->findOneByCustomerOrder($order);

		//Sender name
        $setting_option_name = $repository->findOneByOptionName('order_mail_name');
        $sender_name = $setting_option_name->getOptionValue();
		//Default Sender mail
        $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

		if($mailtype == 'customer'){
			$email_customer = $user->getEmail();
			$arr_mail_to_address = $this->explodeStrToArrayEmail($email_customer);
			$subject = 'Order No. - ใบสั่งซื้อสินค้า : '.$order->getOrderNumber();
		}else{
			//admin email
			//Recipients
	        $setting_option_email = $repository->findOneByOptionName('order_mail_address');
	        $arr_admin_mail_address = $this->explodeStrToArrayEmail($setting_option_email->getOptionValue());
			$arr_mail_to_address = $arr_admin_mail_address;
			$subject = 'You have a new message(s) in your order : '.$order->getOrderNumber();
		}

		$message = (new \Swift_Message($subject))
	        ->setFrom(array($sender_mail_address => $sender_name))
	        ->setTo($arr_mail_to_address)
	        ->setBody(
            $templating->render(
                'ProjectBundle:'.$this->container->getParameter('view_checkout').':_email_order_confirm.html.twig',
                array('arr_cart_data'=>$arr_cart_data,
					'order'=>$order,
					// 'payment_omise'=>$payment_omise,
					// 'epayment'=>$epayment,
					'user'=>$user,
					'client_protocal'=>$client_protocal,
					'bankAccount'=>$bankAccount
				)
            ),
            'text/html'
        );

		try{
            $this->mailer->send($message);
            $response['success'] = true;
            $response['message'] = 'Thank you for your contact. Your message has been sent successfully.';
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = 'Cannot send email.';
        }
        return $response;
	}

	public function sendMailRequestForQuotation($arr_cart_data, $order, $user, $mailtype)
    {
		$templating = $this->container->get('templating');
		$em = $this->container->get('doctrine')->getEntityManager();
		$repository = $em->getRepository(SettingOption::class);
		$client_protocal = $this->getClientProtocal();

		//Sender name
        $setting_option_name = $repository->findOneByOptionName('b2b_quotation_mail_name');
        $sender_name = $setting_option_name->getOptionValue();
		//Default Sender mail
        $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

		if($mailtype == 'customer'){
			$email_customer = $user->getEmail();
			$arr_mail_to_address = $this->explodeStrToArrayEmail($email_customer);
			$subject = 'Request for Quote #'.$order->getOrderNumber();
		}else{
			//admin email
			//Recipients
	        $setting_option_email = $repository->findOneByOptionName('b2b_quotation_mail_address');
	        $arr_admin_mail_address = $this->explodeStrToArrayEmail($setting_option_email->getOptionValue());
			$arr_mail_to_address = $arr_admin_mail_address;
			$subject = 'Request for Quote #'.$order->getOrderNumber();
		}

		$message = (new \Swift_Message($subject))
	        ->setFrom(array($sender_mail_address => $sender_name))
	        ->setTo($arr_mail_to_address)
	        ->setBody(
            $templating->render(
                'ProjectBundle:'.$this->container->getParameter('view_checkout').':_email_request_for_quotation.html.twig',
                array('arr_cart_data'=>$arr_cart_data, 'order'=>$order, 'user'=>$user, 'client_protocal'=>$client_protocal)
            ),
            'text/html'
        );

		try{
            $this->mailer->send($message);
            $response['success'] = true;
            $response['message'] = 'Thank you for your interest in ourt products. Your message has been sent successfully.';
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = 'Cannot send email.';
        }
        return $response;
	}

	public function sendMailPaymentBankTransfer($payment_bank_transfer)
    {
		$templating = $this->container->get('templating');
		$em = $this->container->get('doctrine')->getEntityManager();
		$repository = $em->getRepository(SettingOption::class);

		//Sender name
        $setting_option_name = $repository->findOneByOptionName('order_mail_name');
        $sender_name = $setting_option_name->getOptionValue();
		//Default Sender mail
        $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;
		//Recipients
		$setting_option_email = $repository->findOneByOptionName('order_mail_address');
		$arr_mail_to_address = $this->explodeStrToArrayEmail($setting_option_email->getOptionValue());

		$subject = 'Payment Bank Transfer ';
		// $name = $payment_bank_transfer->getFirstName().' '.$payment_bank_transfer->getLastName();
		$customerOrder = $payment_bank_transfer->getCustomerOrder();
		$user = $customerOrder->getUser();
		$bank_account = $payment_bank_transfer->getBankAccount();

		// debug email template
		// $mail_template = $templating->render(
		// 	'ProjectBundle:'.$this->container->getParameter('view_main').':_email_payment_bank_transfer.html.twig',
		// 	array('payment_bank_transfer'=>$payment_bank_transfer, 'bank_account'=>$bank_account, 'customer_order'=>$customerOrder, 'user'=>$user)
		// );

		$message = (new \Swift_Message($subject))
	        ->setFrom(array($sender_mail_address => $sender_name))
	        ->setTo($arr_mail_to_address)
	        ->setBody(
            $templating->render(
                'ProjectBundle:'.$this->container->getParameter('view_main').':_email_payment_bank_transfer.html.twig',
                array('payment_bank_transfer'=>$payment_bank_transfer, 'bank_account'=>$bank_account, 'customer_order'=>$customerOrder, 'user'=>$user)
            ),
            'text/html'
        );

		try{
            $this->mailer->send($message);
            $response['success'] = true;
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
        }
        return $response;
	}


	public function sendOrderStatusNotificationMail($order, $order_items, $order_status)
    {
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$locale = $request->getLocale();
		$tran_locale = $order->getTransactionLocale();
		if(empty($tran_locale)){
			$tran_locale = $locale;
		}

		$templating = $this->container->get('templating');
		$em = $this->container->get('doctrine')->getEntityManager();
		$repository = $em->getRepository(SettingOption::class);
		$setting_repo = $em->getRepository(SettingOption::class);
		// $client_protocal = $this->getClientProtocal();

		$user = $order->getUser();

		$payment_status_paid = $this->container->getParameter('payment_status_paid');
		$payment_status_shipped = $this->container->getParameter('payment_status_shipped');
		$payment_status_delivered = $this->container->getParameter('payment_status_delivered');
		$payment_status_cancelled = $this->container->getParameter('payment_status_cancelled');
		$payment_status_refunded = $this->container->getParameter('payment_status_refunded');

		//sender name and email
		$setting_option_name = $repository->findOneByOptionName('order_mail_name');
		$sender_name = $setting_option_name->getOptionValue();
		$sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

		//admin recipients email
		$setting_option_email = $repository->findOneByOptionName('order_mail_address');
		$arr_admin_mail = $this->explodeStrToArrayEmail($setting_option_email->getOptionValue());

		$email_customer = $user->getEmail();
		$arr_user_mail = $this->explodeStrToArrayEmail($email_customer);

		//default email template
		$subject_param = 'order_status_paid_subject_'.$tran_locale;
		$body_param = 'order_status_paid_message_'.$tran_locale;
		if($order_status == $payment_status_paid){
			$subject_param = 'order_status_paid_subject_'.$tran_locale;
			$body_param = 'order_status_paid_message_'.$tran_locale;
		}elseif($order_status == $payment_status_shipped){
			$subject_param = 'order_status_shipped_subject_'.$tran_locale;
			$body_param = 'order_status_shipped_message_'.$tran_locale;
		}elseif($order_status == $payment_status_delivered){
			$subject_param = 'order_status_delivered_subject_'.$tran_locale;
			$body_param = 'order_status_delivered_message_'.$tran_locale;
		}elseif($order_status == $payment_status_cancelled){
			$subject_param = 'order_status_cancelled_subject_'.$tran_locale;
			$body_param = 'order_status_cancelled_message_'.$tran_locale;
		}elseif($order_status == $payment_status_refunded){
			$subject_param = 'order_status_refunded_subject_'.$tran_locale;
			$body_param = 'order_status_refunded_message_'.$tran_locale;
		}


		//default subject, body
		$subject = 'Order #'.$order->getOrderNumber();
		$body = '';

		//mail subject
        $email_subject = $setting_repo->findOneByOptionName($subject_param);
        if($email_subject){
			$subject = $email_subject->getOptionValue();
		}
		//mail body
        $email_body = $setting_repo->findOneByOptionName($body_param);
        if($email_body){
			$body = $email_body->getOptionValue();
		}

		//replace parameter
		$patterns = $this->container->getParameter('param_order_status_email_pattern');
		$value_array['email'] = $user->getEmail();
		$value_array['first_name'] = $user->getFirstName();
		$value_array['last_name'] = $user->getLastName();
		$value_array['order_number'] = $order->getOrderNumber();

		$subject = preg_replace($patterns, $value_array, $subject);
        $body = preg_replace($patterns, $value_array, $body);

// echo $subject;
// echo '<br/>';
// echo $body;
// exit;

		$message = (new \Swift_Message($subject))
	        ->setFrom(array($sender_mail_address => $sender_name))
	        ->setTo($arr_user_mail)
			->setBcc($arr_admin_mail)
	        ->setBody(
            $templating->render(
                'ProjectBundle:'.$this->container->getParameter('view_main').':_email_order_status.html.twig',
                array(	'order'=>$order,
						'order_items'=>$order_items,
						'user'=>$user,
						'subject'=>$subject,
	                    'body'=>$body,
						'order_status'=>$order_status,
						'tran_locale'=>$tran_locale
				)
            ),
            'text/html'
        );

		try{
            $this->mailer->send($message);
            $response['success'] = true;
            $response['message'] = 'Email has been sent';
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = 'Cannot send e-mail.';
        }
        return $response;

	}

	public function sendTrackingNotificationMail($order, $order_items, $shipping_carrier, $tracking_number)
    {
		$templating = $this->container->get('templating');
		$em = $this->container->get('doctrine')->getEntityManager();
		$repository = $em->getRepository(SettingOption::class);
		$client_protocal = $this->getClientProtocal();

		$user = $order->getUser();
		$bankAccount = $em->getRepository(BankAccount::Class)->findAllActiveData()->getQuery()->getResult();
		// $payment_omise = $this->container->get('doctrine')->getRepository(CustomerPaymentOmise::class)->findOneByCustomerOrder($order);
		// $epayment = $this->container->get('doctrine')->getRepository(CustomerPaymentEpayment::class)->findOneByCustomerOrder($order);

		//sender name and email
		$setting_option_name = $repository->findOneByOptionName('order_mail_name');
		$sender_name = $setting_option_name->getOptionValue();
		$sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

		$subject = 'A shipment from order #'.$order->getOrderNumber().' is on the way';
		$email_customer = $user->getEmail();
		$arr_user_mail = $this->explodeStrToArrayEmail($email_customer);

		//admin recipients email
		$setting_option_email = $repository->findOneByOptionName('order_mail_address');
		$arr_admin_mail = $this->explodeStrToArrayEmail($setting_option_email->getOptionValue());

		$message = (new \Swift_Message($subject))
	        ->setFrom(array($sender_mail_address => $sender_name))
	        ->setTo($arr_user_mail)
			->setBcc($arr_admin_mail)
	        ->setBody(
            $templating->render(
                'ProjectBundle:'.$this->container->getParameter('view_main').':_email_tracking_notification.html.twig',
                array(	'order'=>$order,
						'order_items'=>$order_items,
						'shipping_carrier'=>$shipping_carrier,
						'tracking_number'=>$tracking_number,
						// 'payment_omise'=>$payment_omise,
						// 'epayment'=>$epayment,
						'user'=>$user,
						'client_protocal'=>$client_protocal,
						'bankAccount'=>$bankAccount
				)
            ),
            'text/html'
        );

		try{
            $this->mailer->send($message);
            $response['success'] = true;
            $response['message'] = 'Thank you for your contact. Your message has been sent successfully.';
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = 'Cannot send email.';
        }
        return $response;
	}

	public function sendMailLowStockReport($arr_data, $no_low_stock)
	{
		$context = $this->router->getContext();
		$host_scheme = $context->getScheme();

		// $host = $context->getScheme().'://'.$context->getHost();

		$templating = $this->container->get('templating');
		$em = $this->container->get('doctrine')->getEntityManager();
		$repository = $em->getRepository(SettingOption::class);

		//Sender name
		$setting_option_name = $repository->findOneByOptionName('low_stock_report_mail_name');
		$sender_name = $setting_option_name->getOptionValue();
		//Default Sender mail
		$sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;
		//Recipients
		$setting_option_email = $repository->findOneByOptionName('low_stock_report_mail_address');
		$arr_mail_to_address = $this->explodeStrToArrayEmail($setting_option_email->getOptionValue());

		$subject = 'Low Stock Notification';

		// // debug email template
		// echo $mail_template = $templating->render(
		// 	'ProjectBundle:'.$this->container->getParameter('view_main').':_email_low_stock_report.html.twig',
		// 		array( 'arr_data'=>$arr_data, 'no_low_stock'=>$no_low_stock )
		// );

		$message = (new \Swift_Message($subject))
	        ->setFrom(array($sender_mail_address => $sender_name))
	        ->setTo($arr_mail_to_address)
	        ->setBody(
				$templating->render(
					'ProjectBundle:'.$this->container->getParameter('view_main').':_email_low_stock_report.html.twig',
					array( 'arr_data'=>$arr_data, 'no_low_stock'=>$no_low_stock, 'host_scheme'=>$host_scheme )
				),
				'text/html'
			);

		try{
			$this->mailer->send($message);
			$response['success'] = true;
			$response['message'] = 'E-mail has been sent successfully';
		}catch(\Exception $e){
			$response['success'] = false;
			$response['message'] = "Can't send E-mail";
		}
	    return $response;
	}
	public function sendMailProductReview($request, $review, $product)
  {
	  $templating = $this->container->get('templating');
	  $em = $this->container->get('doctrine')->getEntityManager();
	  $repository = $em->getRepository(SettingOption::class);
	  $client_protocal = $this->getClientProtocal();

	  // $user = $order->getUser();
	  // $bankAccount = $em->getRepository(BankAccount::Class)->findAllActiveData()->getQuery()->getResult();
	  // $epayment = $this->container->get('doctrine')->getRepository(CustomerPaymentEpayment::class)->findOneByCustomerOrder($order);

	  //sender name and email
	  $setting_option_mail_name = $repository->findOneByOptionName('review_mail_name');
	  $sender_mail_name = $setting_option_mail_name->getOptionValue();
	  $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

	  $subject = 'New product review has been waiting for your approval';
	  // $email_customer = $user->getEmail();
	  //$arr_user_mail = $this->explodeStrToArrayEmail($email_customer);

	  //admin recipients email
	  $setting_option_email = $repository->findOneByOptionName('review_mail_address');
	  $arr_admin_mail = $this->explodeStrToArrayEmail($setting_option_email->getOptionValue());

	  /////////////////////////////////////////////////////////////////////////////////////////////////////
	  // $setting_option_mail_name = SettingOptionQuery::create()->findOneByOptionName('review_mail_name');
  	  // $sender_mail_name = $setting_option_mail_name->getOptionValue();
	  // $setting_option_mail_address = SettingOptionQuery::create()->findOneByOptionName('review_mail_address');
	  //
	  // $arr_order_mail_address = ApplicationController::explodeStrToArrayEmail($setting_option_mail_address->getOptionValue());
	  // $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;
	  // $subject = 'New product review has been waiting for your approval';
	  // $admin_panel_url = $this->generateUrl('admin_review_view',array('id'=>$review->getId()), UrlGeneratorInterface::ABSOLUTE_URL);




		$subject = 'New product review has been waiting for your approval';
		$admin_panel_url = $this->container->get('router')->generate('admin_review_view', array('id'=>$review->getId()),  UrlGeneratorInterface::ABSOLUTE_URL);
		//$admin_panel_url = $this->generateUrl('admin_review_view',array('id'=>$review->getId()), UrlGeneratorInterface::ABSOLUTE_URL);

		$message = (new \Swift_Message($subject))
			->setFrom(array($sender_mail_address => $sender_mail_name))
			->setTo($arr_admin_mail)
			->setBody(
				$templating->render(
					'ProjectBundle:'.$this->container->getParameter('view_main').':_email_product_review.html.twig',
					array('admin_panel_url'=> $admin_panel_url, 'review'=>$review, 'product'=>$product)
				),
				'text/html'
			);

		try{
			$this->mailer->send($message);
			$response['success'] = true;
			$response['message'] = 'E-mail has been sent successfully';
		}catch(\Exception $e){
			$response['success'] = false;
			$response['message'] = "Can't send E-mail";
		}
	}

	public function getClientProtocal()
	{
		$request = $this->container->get('request_stack')->getCurrentRequest();
		if($request->isSecure()){
			$client_protocal = 'https';
		}else{
			$client_protocal = 'http';
		}
		return $client_protocal;
	}

	public function getArrayDateRange($date_range)
	{
		//from format d/m/Y - d/m/Y
		$date_range = str_replace(' ','',$date_range);
		$arr_date = explode('-',$date_range);
    	$start_date = isset($arr_date[0]) ? str_replace('/', '-', $arr_date[0]) : '' ;
		$end_date = isset($arr_date[1]) ? str_replace('/', '-', $arr_date[1]) : '' ;

		$return['start'] = $start_date;
		$return['end'] = $end_date;
		return $return;
	}

	public function getAuthenticationValue($fieldName)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$data = $em->getRepository(Authentication::class)->findOneBy(
			array('name'=>$fieldName), array('id' => 'DESC')
		);
		$value=null;
		if($data){
			$value = $data->getValue();
		}
		return $value;
	}

	public function getCookieCoordinates()
	{
		$coordinates['lat'] = null;
		$coordinates['lng'] = null;
		// cookie validation
		$request = $this->container->get('request_stack')->getCurrentRequest();

		$value_lat = $request->cookies->get('client_coordinate_lat');
		$value_lng = $request->cookies->get('client_coordinate_lng');

		if($value_lat & $value_lng){
			$coordinates['lat'] = $value_lat;
			$coordinates['lng'] = $value_lng;
		}
		return $coordinates;
	}
	public function setCookieCoordinates($coordinates)
	{
		// $clear_response = new Response();
		// $clear_response->headers->clearCookie('client_coordinate_lat');
		// $clear_response->headers->clearCookie('client_coordinate_lng');
		// $clear_response->send();

		$time_cookie = $this->container->getParameter('set_time_cookie_latlnt_limit');
		$cookie_lat = new Cookie('client_coordinate_lat', $coordinates['lat'], time() + $time_cookie );
		$cookie_lng = new Cookie('client_coordinate_lng', $coordinates['lng'], time() + $time_cookie );
		$response = new Response();
		$response->headers->setCookie($cookie_lat);
		$response->headers->setCookie($cookie_lng);
		$response->send();
	}

	public function getCookieGeocodeCoordinates()
	{
		$coordinates = $this->getCookieCoordinates();
		if($coordinates['lat'] && $coordinates['lng']){
			// cookie valid
		}else{
			// cookie expired
			$coordinates = $this->getGeocodeCoordinates();
			if($coordinates['lat'] && $coordinates['lng']){
				$this->setCookieCoordinates($coordinates);
			}
		}
		return $coordinates;
	}

	public function getGeocodeCoordinates()
	{
		$coordinates['lat'] = null;
		$coordinates['lng'] = null;

		$key = $this->getGeolocationApiKey();
		if($key){
			$url = 'https://www.googleapis.com/geolocation/v1/geolocate?key='.$key;
			try {
				$client = new Client();
				$geocodeResponse = $client->post($url)->getBody();
				$geocodeData = json_decode($geocodeResponse);
				if( !empty($geocodeData) && isset( $geocodeData->location ) ){
					$coordinates['lat'] = $geocodeData->location->lat;
					$coordinates['lng'] = $geocodeData->location->lng;
				}
			} catch (\Exception $e) {
			  // echo $e->getMessage();
			}
		}
		return $coordinates;
	}

	public function getDirectionsBetweenLocations($origin_lat_lnt, $destination_lat_lnt, $origin_place_id=null, $destination_place_id=null)
	{
		$key = $this->getDirectionsApiKey();
		$origin = ($origin_place_id) ? 'place_id:'.$origin_place_id : $origin_lat_lnt ;
		$destination = ($destination_place_id) ? 'place_id:'.$destination_place_id : $destination_lat_lnt ;
		$mode = 'driving';
		$avoid = 'ferries';

		//https://developers.google.com/maps/documentation/directions/usage-and-billing
		//Standard Usage Limits : 2500 free directions requests per day, calculated as the sum of client-side and server-side queries.
		$url = 'https://maps.googleapis.com/maps/api/directions/json?key='.$key.'&origin='.$origin.'&destination='.$destination.'&mode='.$mode.'&avoid='.$avoid;

		$client = new Client();
		$geocodeResponse = $client->get($url)->getBody();
		$geocodeData = json_decode($geocodeResponse);

		$distance['text'] = null;
		$distance['value'] = null;

		if( !empty( $geocodeData ) && $geocodeData->status == 'OK' && isset( $geocodeData->routes ) && isset( $geocodeData->routes[0] ) ){
			$distance['text'] = $geocodeData->routes[0]->legs[0]->distance->text;
			$distance['value'] = $geocodeData->routes[0]->legs[0]->distance->value;
			// value is total distance in meters.
		}else{
			//get distance from here map.
			$distance = $this->getHereMapDirectionsBetweenLocations($origin_lat_lnt, $destination_lat_lnt);
		}

		return $distance;
	}

	public function getHereMapDirectionsBetweenLocations($origin_lat_lnt, $destination_lat_lnt)
	{
		//https://developer.here.com
		//account:num@zap-interactive.com project:Marathon plan:Freemium 5K monthly
		$app_id = 'EDEFhfa1Df4upvAnYsnc';
		$app_code = 'fSyRviE3Pv0x1dnLM1XW5w';

		$url = 'https://route.api.here.com/routing/7.2/calculateroute.json?app_id='.$app_id.'&app_code='.$app_code.'&waypoint0=geo!'.$origin_lat_lnt.'&waypoint1=geo!'.$destination_lat_lnt.'&mode=shortest;car;traffic:disabled';
		$client = new Client();
		$geocodeResponse = $client->get($url)->getBody();
		$geocodeData = json_decode($geocodeResponse);

		$distance['text'] = null;
		$distance['value'] = null;

		if( !empty($geocodeData) && isset( $geocodeData->response ) && isset( $geocodeData->response->route[0] ) ){
			$distance_value = $geocodeData->response->route[0]->summary->distance;
			$distance['value'] = $distance_value;
			$distance_km = ($distance['value']/1000);
			$distance['text'] =  round($distance_km, 1, PHP_ROUND_HALF_UP).' km';
			// total distance in meters.
		}
		return $distance;
	}

	public function getGeocodeCoordinatesByAddress($address, $city, $state, $zip, $key)
	{
		/*
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address.' '.$city.', '.$state.' '.$zip).'&key='.$key;

		$client = new Client();
		$geocodeResponse = $client->get($url)->getBody();
		$geocodeData = json_decode( $geocodeResponse );

		$coordinates['lat'] = null;
		$coordinates['lng'] = null;

		if( !empty( $geocodeData )
		&& $geocodeData->status != 'ZERO_RESULTS'
		&& isset( $geocodeData->results )
		&& isset( $geocodeData->results[0] ) ){
			$coordinates['lat'] = $geocodeData->results[0]->geometry->location->lat;
			$coordinates['lng'] = $geocodeData->results[0]->geometry->location->lng;
		}
		return $coordinates;
		*/
	}

	public function setArrayShowroomDataFromObj($showroom)
	{
		$data_result = array();
		$data_result['title'] = $showroom->getTitle();
		$data_result['address'] = $showroom->getAddress();
		$data_result['latitude'] = $showroom->getLatitude();
		$data_result['longitude'] = $showroom->getLongitude();
		$data_result['placeId'] = $showroom->getPlaceId();
		$data_result['phone'] = $showroom->getPhone();
		$data_result['fax'] = $showroom->getFax();
		$data_result['mobile'] = $showroom->getMobile();
		return $data_result;
	}

	public function sendmail_request_service($urls,$subject,$data)
    {
        // $em = $this->getDoctrine()->getManager()->getRepository(SettingOption::class);
		$templating = $this->container->get('templating');
		$em = $this->container->get('doctrine')->getEntityManager()->getRepository(SettingOption::class);
        //Recipients
        $setting_option_email = $em->findOneByOptionName('request_service_mail_address');
        $arr_contact_mail_address = explode(",", $setting_option_email->getOptionValue());
        //Sender name
        $setting_option_name = $em->findOneByOptionName('request_service_mail_name');
        $contact_mail_name = $setting_option_name->getOptionValue();
        //Default email
        $sender_mail_address = $this->container->getParameter('default_sender_mail_address') ;

        $message = (new \Swift_Message($subject))
        ->setFrom(array($sender_mail_address => $contact_mail_name))
        ->setTo($arr_contact_mail_address)
        ->setBody(
            $templating->render(
                'ProjectBundle:'.$this->container->getParameter('view_main').':_email_request_service.html.twig',
                array('urls'=> $urls,'subject'=>$subject,'data'=>$data)
            ),
            'text/html'
        );

        try{
            $this->mailer->send($message);
            $response['success'] = true;
            $response['message'] = $this->translator->trans('request_service.success');
        }catch(\Exception $e){
            #Do nothing
            $response['success'] = false;
            $response['message'] = $this->translator->trans('request_service.success');
        }

        return $response;
    }

	public function getHtmlTreeViewOptions()
	{
		$options = array(
		    'decorate' => true,
			'rootOpen' => '',
			'rootClose' => '',
			'childOpen' => '',
		    'childClose' => '',
		    'nodeDecorator' => function($node){
				$html = '<div class="level_'.$node['lvl'].'">'.$node['translations'][Locale::getDefault()]['title'].'</div>';
		        return $html;
		    }
		);
		return $options;
	}

	public function getInputSelectTreeViewOptions($selected_id=null)
	{
		$this->product_category_selected_id = $selected_id;

		$options = array(
		    'decorate' => true,
			'rootOpen' => '',
			'rootClose' => '',
			'childOpen' => '',
		    'childClose' => '',
		    'nodeDecorator' => function($node){

				//set selected
				$attr_selected = ($this->product_category_selected_id && $node['id'] == $this->product_category_selected_id) ? 'selected' : '' ;
				$html = '<option class="level_'.$node['lvl'].'" value="'.$node['id'].'" '.$attr_selected.'>'. $node['translations'][Locale::getDefault()]['title'] . '</option>';

				// if($node['lvl'] > 0) {
				// $html = '<option class="level_'.$node['lvl'].'" value="'.$node['id'].'" '.$attr_selected.'>'. $node['translations'][Locale::getDefault()]['title'] . '</option>';
				// }else{
				// $html = '';
				// }

		        return $html;
		    }
		);
		return $options;
	}

	public function getAdminTreeViewWithImgOptions()
	{
		$options = array(
		    'decorate' => true,
			'rootOpen' => '<ul>',
			'rootClose' => '</ul>',
		    'childOpen' => '<li>',
		    'childClose' => '</li>',

		    'nodeDecorator' => function($node){

				$node_id = $node['id'];
				$node_lvl = $node['lvl'];
				$edit_link = $node_id.'/edit';
				$delete_link = $node_id.'/delete';
				$move_position_link = $node_id.'/move';
				$move_up_link = $node_id.'/move/up';
				$move_down_link = $node_id.'/move/down';
				$title = $node['translations'][Locale::getDefault()]['title'];
				$description = $node['translations'][Locale::getDefault()]['description'];
				$html_desc = '';
				if($description){
					$html_desc = '&nbsp;&nbsp;<small>'.$description.'</small>';
				}

				if($node_lvl>=3){
					$pattern_image_small = $node['patternImageSmall'];
					$category_code = $node['categoryCode'];
					$is_only_gallery = $node['isOnlyGallery'];
					$html_text_title='';
					$html_text_only_gallery='';

					if($pattern_image_small){
						$html_text_title .= '<img src="'.$pattern_image_small.'" style="max-width: 35px;" />&nbsp;&nbsp;';
					}

					if($category_code){
						$html_text_title .= $category_code.'&nbsp;&nbsp;';
					}

					$html_text_title .= $title.'&nbsp;&nbsp;';

					if($is_only_gallery){
						$html_text_only_gallery .= '<small>Only Gallery</small> &nbsp;&nbsp;';
					}

					$html = '<a href="'.$edit_link.'">'.$html_text_title.$html_desc.'</a>'.$html_text_only_gallery;

				}elseif($node_lvl==2){
					$category_code = $node['categoryCode'];
					$html_text_title= $category_code.'&nbsp;&nbsp;';
					$html_text_small='';
					if($category_code!=$title){
						$html_text_small = $title.$html_desc;
					}

					$html = '<a href="'.$edit_link.'">'.$html_text_title.'</a>'.'<small>'.$html_text_small.'</small>';

				}elseif($node_lvl==1){
					$html = '<a href="'.$edit_link.'">'.$title.$html_desc.'</a>';
				}

				// $html_link_move = '<a href="'.$move_position_link.'" title="Move Position"><i class="fa fa-arrows"></i></a>&nbsp;&nbsp;';
				$html_link_move = '';
				$html .= '<span class="pull-right"> <a href="'.$move_up_link.'" title="Move Up"><i class="fa fa-chevron-circle-up"></i></a>&nbsp;&nbsp;<a href="'.$move_down_link.'"><i class="fa fa-chevron-circle-down" title="Move Down"></i></a>&nbsp;&nbsp; '.$html_link_move.'<a href="'.$edit_link.'" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;<a href="'.$delete_link.'" onclick="return confirm(\'Are you sure you want to delete?\');" title="Delete"><i class="fa fa-trash"></i></a> </span>';

		        return $html;
		    }
		);
		return $options;
	}

	public function getAdminTreeViewOptions()
	{
		// $options = array('decorate' => false);
		$options = array(
		    'decorate' => true,

		    // 'rootOpen' => function($tree){
			// 	if(count($tree) && ($tree[0]['lvl'] == 0)){
			// 		return '';
            //     }else{
			// 		return '<ul>';
			// 	}
			// },
		    // 'rootClose' => function($tree){
			// 	if(count($tree) && ($tree[0]['lvl'] == 0)){
			// 		return '';
            //     }else{
			// 		return '</ul>';
			// 	}
			// },
			// 'childOpen' => function($tree){
			// 	if(count($tree) && ($tree['lvl'] == 0)){
			// 		return '';
            //     }else{
			// 		return '<li>';
			// 	}
			// },
			// 'childClose' => function($tree){
			// 	if(count($tree) && ($tree['lvl'] == 0)){
			// 		return '';
            //     }else{
			// 		return '</li>';
			// 	}
			// },

			'rootOpen' => '<ul>',
			'rootClose' => '</ul>',
		    'childOpen' => '<li>',
		    'childClose' => '</li>',

		    'nodeDecorator' => function($node){

				// if($node['lvl'] > 0) {

					$node_id = $node['id'];
					$edit_link = $node_id.'/edit';
					$delete_link = $node_id.'/delete';
					$move_position_link = $node_id.'/move';
					$move_up_link = $node_id.'/move/up';
					$move_down_link = $node_id.'/move/down';

					$html = '<small class="label label-default"> #'.$node_id.'</small> <a href="'.$edit_link.'">'.$node['translations'][Locale::getDefault()]['title'].'</a>  <span class="pull-right"> <a href="'.$move_up_link.'" title="Move Up"><i class="fa fa-chevron-circle-up"></i></a>&nbsp;&nbsp;<a href="'.$move_down_link.'"><i class="fa fa-chevron-circle-down" title="Move Down"></i></a>&nbsp;&nbsp;<a href="'.$move_position_link.'" title="Move Position"><i class="fa fa-arrows"></i></a>&nbsp;&nbsp;<a href="'.$edit_link.'" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;<a href="'.$delete_link.'" onclick="return confirm(\'Are you sure you want to delete?\');" title="Delete"><i class="fa fa-trash"></i></a> </span>';


				// }else{
				// 	$html = '';
				// }

		        return $html;
		    }
		);
		return $options;
	}

	public function getAdminTreeViewWithToppageOptions()
	{
		// $options = array('decorate' => false);
		$options = array(
		    'decorate' => true,
			'rootOpen' => '<ul>',
			'rootClose' => '</ul>',
		    'childOpen' => '<li>',
		    'childClose' => '</li>',

		    'nodeDecorator' => function($node){

					$node_id = $node['id'];
					$node_lvl = $node['lvl'];
					$is_top_page = $node['isTopPage'];
					$edit_link = $node_id.'/edit';
					$delete_link = $node_id.'/delete';
					$move_position_link = $node_id.'/move';
					$move_up_link = $node_id.'/move/up';
					$move_down_link = $node_id.'/move/down';

					$html = '<small class="label label-default"> #'.$node_id.'</small> <a href="'.$edit_link.'">'.$node['translations'][Locale::getDefault()]['title'].'</a>  ';
					$html_action = '<span class="pull-right"> <a href="'.$move_up_link.'" title="Move Up"><i class="fa fa-chevron-circle-up"></i></a>&nbsp;&nbsp;<a href="'.$move_down_link.'"><i class="fa fa-chevron-circle-down" title="Move Down"></i></a>&nbsp;&nbsp;<a href="'.$move_position_link.'" title="Move Position"><i class="fa fa-arrows"></i></a>&nbsp;&nbsp;<a href="'.$edit_link.'" title="Edit"><i class="fa fa-pencil-square-o"></i></a>&nbsp;&nbsp;<a href="'.$delete_link.'" onclick="return confirm(\'Are you sure you want to delete?\');" title="Delete"><i class="fa fa-trash"></i></a> </span>';

				if($is_top_page > 0) {
					$html .= '&nbsp;<small>Show top page</small> &nbsp;&nbsp;';
				}

		        return $html.$html_action;
		    }
		);
		return $options;
	}

	///////////////////////////////////////////////////////// Review /////////////////////////////////////////////////////
	public function showReviewerByFullName($full_name)
  {
		$arr_name = explode(" ", $full_name);
		if(count($arr_name)>1){
			$reviewer_name = self::showReviewerName($arr_name[0], $arr_name[1]);
		}else{
			$reviewer_name = $arr_name[0];
		}
		return $reviewer_name;
	}

	public function showReviewerName($first_name, $last_name){
		if($last_name){
			$last_name = mb_substr($last_name,0,1,'UTF-8').".";
		}
		$reviewer_name = $first_name.' '.$last_name;
		return $reviewer_name;
	}

	public function makeReviewerName($first_name, $last_name){
		$reviewer_name = $first_name.' '.$last_name;
		return $reviewer_name;
	}

	public function chkProductReviewEnable()
	{
		$enable = 0;
		$em = $this->container->get('doctrine')->getEntityManager();
		$data_setting = $em->getRepository(ReviewSetting::class)->createQueryBuilder('rst')->getQuery()->getOneOrNullResult();

		if($data_setting){
			if($data_setting->getStatus()==1){
				$enable = 1;
			}
		}
		return $enable;
	}

	public function getCalculateRatingAndReviewData($product_id)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$arr_rating_data = array(
			'count_review' => 0,
			'count_rating' => 0,
			'sum_rating' => 0,
			'average_rating' => 0,
		);
		$sum_rating = 0;
		$average_rating = 0;
		if($product_id){
			$query_review = $em->getRepository(Review::class)->getAllReviewByProduct(false,false,$product_id)->getQuery()->getResult();
			//$count_review = ReviewQuery::create()->getAllReviewByProduct($product_id)->count();
			$count_review = count($query_review);

			//$query_rating = ReviewQuery::create()->getAllRatingByProduct($product_id);
			$query_rating = $em->getRepository(Review::class)->getAllRatingByProduct(false,false,$product_id)->getQuery()->getResult();
			$count_rating = count($query_rating);

			//$query_sum_rating = ReviewQuery::create()->getSumRatingByProduct($product_id)->findOne();
			$query_sum_rating = $em->getRepository(Review::class)->getSumRatingByProduct(false,false,$product_id)->getQuery()->getResult();


			if($query_sum_rating){
				$sum_rating = $query_sum_rating[0]['sum_rating'];
			}

			if($count_rating>0){
				$average_rating = ($sum_rating / $count_rating);
				$average_rating = number_format((float)$average_rating, 1, '.', '');
			}

			$arr_rating_data['count_review'] = $count_review;
			$arr_rating_data['count_rating'] = $count_rating;
			$arr_rating_data['sum_rating'] = $sum_rating;
			$arr_rating_data['average_rating'] = $average_rating;
		}
		return $arr_rating_data;
	}

	public function setProductRatingAndReview($product)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$arr_rating_data = array();
		$enable = self::chkProductReviewEnable();
		if($enable){
			$product_id = $product->getId();
			$arr_rating_data = self::getCalculateRatingAndReviewData($product_id);

			$product->setReviewCount($arr_rating_data['count_review']);
			$product->setRatingCount($arr_rating_data['count_rating']);
			$product->setRatingSum($arr_rating_data['sum_rating']);
			$product->setRatingAverage($arr_rating_data['average_rating']);
			$em->persist($product);
			$em->flush($product);
			//$product->save();
		}
	}

	public function getGroupDataRating($product_id, $count_rating)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$data_ratings = array();
		if($product_id){
			//$group_data_ratings = Review::create()->getGroupRatingByProduct($product_id)->find();
			$group_data_ratings = $em->getRepository(Review::class)->getGroupRatingByProduct(false,false,$product_id)->getQuery()->getResult();


			if($group_data_ratings){
				foreach ($group_data_ratings as $group_data_rating) {

					$group_rating = $group_data_rating[0]->getRatingScore();
					$data_ratings[$group_rating]['count'] = $group_data_rating['count_rating'];
					$percentage = @($group_data_rating['count_rating'] / $count_rating) * 100;
					$data_ratings[$group_rating]['percentage'] = number_format((float)$percentage, 2, '.', '');
				}
			}
			//get 1 to 5 star rating data
			for ($i=1; $i<6; $i++) {
				if(!isset($data_ratings[$i])){
					//no data
					$data_ratings[$i]['count'] = '0';
					$data_ratings[$i]['percentage'] = '0';
				}
			}
			ksort($data_ratings);
		}
		return $data_ratings;
	}

	public function getRattingData($product)
	{
		$enable = self::chkProductReviewEnable();

		$count_review = 0;
		$count_rating = 0;
		$sum_rating = 0;
		$average_rating = 0;
		$data_ratings = array();

		if($enable){
			$product_id = $product->getId();

			//change to get data from product
			$count_review = ($product->getReviewCount()) ? $product->getReviewCount() : 0;

			$count_rating = ($product->getRatingCount()) ? $product->getRatingCount() : 0;
			$sum_rating = ($product->getRatingSum()) ? $product->getRatingSum() : 0 ;
			$average_rating = ($product->getRatingAverage()) ? $product->getRatingAverage() : 0;



			 $data_ratings = self::getGroupDataRating($product_id, $count_rating);

		}

		return $arr_rating = array(
			'enable' => $enable,
			'count_review' => $count_review,
			'count_rating' => $count_rating,
			'sum_rating' => $sum_rating,
			'average_rating' => floatval($average_rating),
			'data_ratings' => $data_ratings,
		);
	}

	public function getNewsAuthorName($user)
	{
		$author = '';
		if($user->getFirstName()){
			$author = $user->getFirstName();
		}
		if($user->getLastName()){
			$author = ($author) ? $author.' '.$user->getLastName() : $user->getLastName() ;
		}

		return $author;
	}

	public function getChildrenNewsCategoryByCategoryId($arr_search)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$cateogry_repo = $em->getRepository(NewsCategory::class);
		$data_cat_id = array();
		if(isset($arr_search['category_id']) && $arr_search['category_id']){
			foreach ($arr_search['category_id'] as $key => $category_id) {
				$arr_cat_id = array();
				$pr_category = $cateogry_repo->find($category_id);
				$children = $cateogry_repo->children($pr_category, false, null, 'asc', true);
				foreach ($children as $chi) {
					$arr_cat_id[] = $chi->getId();
				}
				$data_cat_id = array_merge($data_cat_id, $arr_cat_id);
			}
			$data_cat_id = array_unique($data_cat_id);
		}
		return $data_cat_id;
	}
}