<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use ProjectBundle\Entity\Distributor;
use ProjectBundle\Entity\DistributorImage;


use ProjectBundle\Entity\Authentication;

use ProjectBundle\Form\Type\AdminDistributorType;
use ProjectBundle\Form\Type\AdminDistributorSearchType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminDistributorController extends Controller
{
    const ROUTER_INDEX = 'admin_distributor';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
  	const ROUTER_PREFIX = 'distributor';
	const ROUTER_CONTROLLER = 'AdminDistributor';

	protected function getQuerySearchData($arr_query_data)
	{
		$repository = $this->getDoctrine()->getRepository(Distributor::class);
    	$query = $repository->findAllData($arr_query_data);
		return $query;
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
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

		//$arr_query_data = $util->prepare_query_data($request);

        $form_search = $this->createForm(AdminDistributorSearchType::class, null, array('allow_extra_fields'=>true));
        $form_search->handleRequest($request);
        $arr_query_data = $request->query->get('admin_distributor_search');


		$query = $this->getQuerySearchData($arr_query_data);
		$paginated = $util->setPaginatedOnPagerfanta($query);

		$util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
			'paginated' =>$paginated,
            'form_search' => $form_search->createView(),
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function newAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$form = $this->createForm(AdminDistributorType::class, new Distributor());
		$gallery_images=array();

		$data = new Distributor();
		$date = new \DateTime();
		//$data->setPublicDate($date);

		$google_maps_api_key = $util->getGoogleMapsApiKey();

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'google_maps_api_key'=>$google_maps_api_key,
			'gallery_images'=>$gallery_images
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function createAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$image_path = $request->get('img_path');

		$data = new Distributor();
		$gallery_images=array();
		$form = $this->createForm(AdminDistributorType::class, $data);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$em->persist($data);
            if(count($image_path)>0){
                foreach ($image_path as $image_uri) {
                    if($image_uri){
                        $gallery_image = new DistributorImage();
                        $gallery_image->setImage($image_uri);
                        $gallery_image->setDistributor($data);
                        $em->persist($gallery_image);
                    }
                }
            }
			$em->flush();

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}

		$google_maps_api_key = $util->getGoogleMapsApiKey();

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'google_maps_api_key'=>$google_maps_api_key,
			'gallery_images'=>$gallery_images
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function editAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$data = $this->getDoctrine()->getRepository(Distributor::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }
        $gallery_images = $data->getDistributorImage();


		$form = $this->createForm(AdminDistributorType::class, $data);

		$google_maps_api_key = $util->getGoogleMapsApiKey();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			'google_maps_api_key'=>$google_maps_api_key,
			'gallery_images'=>$gallery_images
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		//get image_gallery
		$image_path = $request->get('img_path');
		//get delete image_gallery
		$del_img_gallery_ids = $request->get('del_img_gallery');

		$data = $em->getRepository(Distributor::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }
		$gallery_images = $data->getImage();

		$form = $this->createForm(AdminDistributorType::class, $data);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			if($request->get('removefileimage')==1){
				$data->removeImage();
			}

			//save image_gallery

			if(is_array($image_path) && count($image_path)>0){
				foreach ($image_path as $image_uri) {
					if($image_uri){
						$gallery_image = new DistributorImage();
						$gallery_image->setImage($image_uri);
						$gallery_image->setDistributor($data);
						$em->persist($gallery_image);
					}
				}
			}

			//delete image_gallery
			if(is_array($del_img_gallery_ids) && count($del_img_gallery_ids)>0){
				foreach ($del_img_gallery_ids as $del_img_id) {
					$del_style_image = $em->getRepository(DistributorImage::class)->find($del_img_id);
					$em->remove($del_style_image);
				}
			}



			$em->flush();

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}

		$google_maps_api_key = $util->getGoogleMapsApiKey();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			'google_maps_api_key'=>$google_maps_api_key,
			'gallery_images'=>$gallery_images
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(Distributor::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$em->remove($data);
		$em->flush();

		$util->setRemoveNotice();
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
				$data = $em->getRepository(Distributor::class)->find($data_id);
				if ($data) {
					try {
						$em->remove($data);
						$em->flush();
						$flg_del = true;
					} catch(\Doctrine\DBAL\DBALException $e) {
						$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getTitle());
					}
				}
			}
			if ($flg_del) {
				$util->setRemoveNotice();
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function group_enableAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$data_ids = $request->get('data_ids');
		if ($data_ids) {
			$flg_pub = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(Distributor::class)->find($data_id);
				if ($data) {
					$data->setStatus(1);
					$flg_pub = true;
				}
			}
			try {
				$em->flush();
			} catch(\Exception $e) {
				$util->setCustomeFlashMessage('warning', $msg="Can't enable ");
			}
			if($flg_pub){
				$util->setCustomeFlashMessage('notice', $msg="Published ");
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function group_disableAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$data_ids = $request->get('data_ids');
		if ($data_ids) {
			$flg_pub = false;
			foreach ($data_ids as $data_id) {
				$data = $em->getRepository(Distributor::class)->find($data_id);
				if ($data) {
					$data->setStatus(0);
					$flg_pub = true;
				}
			}
			try {
				$em->flush();
			} catch(\Exception $e) {
				$util->setCustomeFlashMessage('warning', $msg="Can't disable ");
			}
			if ($flg_pub) {
				$util->setCustomeFlashMessage('notice', $msg="Unpublished ");
			}
		}
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function sortAction(Request $request)
	{
		$util = $this->container->get('utilities');
		// $arr_query_data = $util->prepare_query_data($request);
		$form_search = $this->createForm(AdminDistributorSearchType::class, null, array('allow_extra_fields'=>true));
		$form_search->handleRequest($request);
		$arr_query_data = $request->query->get('admin_distributor_search');

		if ($form_search->isSubmitted() && $form_search->isValid()) {
			$datas = $this->getQuerySearchData($arr_query_data)->getQuery()->getResult();
			return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':sort.html.twig', array('datas' =>$datas,'form_search' => $form_search->createView(),));
		}else{
			$datas = null;
		}

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':sort.html.twig', array('datas' =>$datas,'form_search' => $form_search->createView(),));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function sort_prosessAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$i=0;
		$sorted = $request->get('sort');
		if ($sorted) {
			foreach ($sorted as $data_id) {
				$data = $em->getRepository(Distributor::class)->find($data_id);
				if ($data) {
					$i=$i+1;
					$data->setPosition($i);
				}
			}
			try {
				$em->flush();
				$status='complete';
			} catch(\Exception $e) {
				$status='error';
			}
			return new Response($status);
		}
	}
}
