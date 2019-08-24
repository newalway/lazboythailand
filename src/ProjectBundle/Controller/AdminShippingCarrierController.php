<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ProjectBundle\Form\Type\AdminShippingCarrierType;
use ProjectBundle\Entity\ShippingCarrier;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminShippingCarrierController extends Controller
{
	const ROUTER_INDEX = 'admin_shipping_carrier';
    const ROUTER_CONTROLLER = 'AdminShippingCarrier';
    const ROUTER_ADD = self::ROUTER_INDEX.'_new';
    const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';

	protected function getQuerySearchData($arr_query_data)
    {
        $repository = $this->getDoctrine()->getRepository(ShippingCarrier::class);
        $query = $repository->findAllData($arr_query_data);
        return $query;
    }

    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function indexAction(Request $request)
    {
        $util = $this->container->get('utilities');
        $session = $request->getSession();
        try {
            $acctoken = $util->getAccessToken();
        } catch(\Exception $e) {
            return $this->redirectToRoute('admin_user_generate_token');
        }

        $arr_query_data = $util->prepare_query_data($request);
        $query = $this->getQuerySearchData($arr_query_data);
        $paginated = $util->setPaginatedOnPagerfanta($query);

        $util->setBackToUrl();
        return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array('paginated' =>$paginated));
    }

    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function newAction(Request $request)
    {
        $shipping_rate = new ShippingCarrier();
        $form = $this->createForm(AdminShippingCarrierType::class,$shipping_rate);

        return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
            'form' =>$form->createView()
        ));
    }

    /**
    * @Secure(roles="ROLE_ADMIN")
    */
    public function createAction(Request $request)
    {
        $data = new ShippingCarrier();
        $util = $this->container->get('utilities');
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(AdminShippingCarrierType::class, $data);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($data);
            $em->flush();

            $util->setCreateNotice();
            $redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
            return $this->redirect($redirect_uri);
        }else{
            return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
                'form' =>$form->createView()
            ));
        }
    }

	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function editAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $this->getDoctrine()->getRepository(ShippingCarrier::class)->find($request->get('id'));
		$form = $this->createForm(AdminShippingCarrierType::class, $data);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($data);
			$em->flush();

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}else{
			return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
				'form' =>$form->createView()
			));
		}
	}

	/**
	* @Secure(roles="ROLE_ADMIN")
	*/
	public function deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(ShippingCarrier::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		try {
			$em->remove($data);
			$em->flush();
			$util->setRemoveNotice();
		} catch(\Doctrine\DBAL\DBALException $e) {
			$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getName());
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function group_deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data_ids = $request->get('data_ids');

		if ($data_ids) {
			$flg_del = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(ShippingCarrier::class)->find($data_id);
				if ($data) {
					try {
						$em->remove($data);
						$em->flush();
						$flg_del = true;
					} catch(\Doctrine\DBAL\DBALException $e) {
						$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getName());
					}
				}
			}
			if ($flg_del) {
				$util->setRemoveNotice();
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

}