<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\Inspiration;
use ProjectBundle\Entity\InspirationCategory;

use ProjectBundle\Form\Type\AdminInspirationType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminInspirationController extends Controller
{
	const ROUTER_INDEX = 'admin_inspiration';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
  	const ROUTER_PREFIX = 'inspiration';
	const ROUTER_CONTROLLER = 'AdminInspiration';

	protected function getQuerySearchData($arr_query_data)
	{
		$repository = $this->getDoctrine()->getRepository(Inspiration::class);
    	$query = $repository->findAllData($arr_query_data);
		return $query;
	}

	public function prepare_query_data($request)
	{
		$arr_data = $request->query->get('search_data');
		$arr_category = $request->query->get('category');

		//default data
		$arr_query_data = array('q'=>'', 'category_id'=>'');
		if(!empty($arr_data)){
			$arr_query_data['q'] = trim($arr_data['q']);
		}
		if(!empty($arr_category)){
			$arr_query_data['category_id'] = $arr_category['parent'];
		}
		return $arr_query_data;
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

		$arr_query_data = $this->prepare_query_data($request);
		$category_id = null;
		if($arr_query_data['category_id']){
			$category_id = $arr_query_data['category_id'];
			//get children category_id
			$searchFormData['category_id'] = array($category_id);
			$arr_query_data['category_id'] = $util->getChildrenInspirationCategoryByCategoryId($searchFormData);
		}

		$query = $this->getQuerySearchData($arr_query_data);
		$paginated = $util->setPaginatedOnPagerfanta($query);

		//category
		$em = $this->getDoctrine()->getManager();
		$category_root_id = $this->container->getParameter('inspiration_category_root_id');
		$repo = $em->getRepository(InspirationCategory::class);
		$category_query = $repo->findDataByRootId($category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions($category_id);
		$option_tree = $repo->buildTree($category_query->getArrayResult(), $options);

		$util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
			'paginated' =>$paginated,
			'option_tree'=>$option_tree,
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function newAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$acctoken = $util->getAccessToken();
		// $gallery_images=array();

		$data = new Inspiration();
		$form = $this->createForm(AdminInspirationType::class, $data, array('allow_extra_fields'=>true));
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			// 'gallery_images'=>$gallery_images,
			'acctoken'=>$acctoken
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function createAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$acctoken = $util->getAccessToken();
		$em = $this->getDoctrine()->getManager();

		//get image_gallery
		// $image_path = $request->get('img_path');
		// $gallery_images=array();

		$data = new Inspiration();

		$form = $this->createForm(AdminInspirationType::class, $data, array('allow_extra_fields'=>true));
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$em->persist($data);

			//save image_gallery
			// if(isset($image_path)>0){
			// 	foreach ($image_path as $image_uri) {
			// 		if($image_uri){
			// 			$gallery_image = new InspirationImage();
			// 			$gallery_image->setImage($image_uri);
			// 			$gallery_image->setInspiration($data);
			// 			$em->persist($gallery_image);
			// 		}
			// 	}
			// }

	    	$em->flush();

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			// 'gallery_images'=>$gallery_images,
			'acctoken'=>$acctoken
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function editAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$acctoken = $util->getAccessToken();
		$data = $this->getDoctrine()->getRepository(Inspiration::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }
		// $gallery_images = $data->getInspirationImages();
		$form = $this->createForm(AdminInspirationType::class, $data, array('allow_extra_fields'=>true));
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			// 'gallery_images'=>$gallery_images,
			'acctoken'=>$acctoken
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$acctoken = $util->getAccessToken();
		$em = $this->getDoctrine()->getManager();

		//get image_gallery
		// $image_path = $request->get('img_path');

		//get delete image_gallery
		// $del_img_gallery_ids = $request->get('del_img_gallery');

		$data = $em->getRepository(Inspiration::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }
		// $gallery_images = $data->getInspirationImages();

		$form = $this->createForm(AdminInspirationType::class, $data, array('allow_extra_fields'=>true));
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			//remove main image
			if($request->get('removefileimage')==1){
				$data->removeImage();
			}

			// //save image_gallery
			// if(count($image_path)>0){
			// 	foreach ($image_path as $image_uri) {
			// 		if($image_uri){
			// 			$gallery_image = new InspirationImage();
			// 			$gallery_image->setImage($image_uri);
			// 			$gallery_image->setInspiration($data);
			// 			$em->persist($gallery_image);
			// 		}
			// 	}
			// }
			// //delete image_gallery
			// if(count($del_img_gallery_ids)>0){
			// 	foreach ($del_img_gallery_ids as $del_img_id) {
			// 		$del_style_image = $em->getRepository(InspirationImage::class)->find($del_img_id);
			// 		$em->remove($del_style_image);
			// 	}
			// }

			$em->flush();

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			// 'gallery_images'=>$gallery_images,
			'acctoken'=>$acctoken
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(Inspiration::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		try {
		    $em->remove($data);
		    $em->flush();
			$util->setRemoveNotice();
		} catch(\Doctrine\DBAL\DBALException $e) {
			$util->setCustomeFlashMessage('warning', $msg="Can't delete ".$data->getTitle());
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
				$data = $em->getRepository(Inspiration::class)->find($data_id);
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
				$data = $em->getRepository(Inspiration::class)->find($data_id);
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
				$data = $em->getRepository(Inspiration::class)->find($data_id);
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
		$arr_query_data = $util->prepare_query_data($request);
		$arr_query_data['is_highlight'] = 1;
		$datas = $this->getQuerySearchData($arr_query_data)->getQuery()->getResult();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':sort.html.twig', array('datas' =>$datas));
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
				$data = $em->getRepository(Inspiration::class)->find($data_id);
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