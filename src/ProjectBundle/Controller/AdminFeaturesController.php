<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\Features;
use ProjectBundle\Entity\FeaturesTranslation;

use ProjectBundle\Form\Type\AdminFeaturesType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Intl\Locale;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminFeaturesController extends Controller
{
	const ROUTER_INDEX = 'admin_features';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
	const ROUTER_PREFIX = 'features';
	const ROUTER_CONTROLLER = 'AdminFeatures';

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
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);
		$features_root_id = $this->container->getParameter('features_root_id');

		$query = $repo->findDataByRootId($features_root_id)->getQuery();
		$options = $util->getAdminTreeViewOptions();
		$tree = $repo->buildTree($query->getArrayResult(), $options);

		$util->setBackToUrl();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
			'tree' => $tree
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
		$features_root_id = $this->container->getParameter('features_root_id');

		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);

		// $query = $repo->findChildrenByParentId(31)->getQuery();
		$query = $repo->findDataByRootId($features_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
		$option_tree = $repo->buildTree($query->getArrayResult(), $options);

		$form = $this->createForm(AdminFeaturesType::class, new Features(), array('allow_extra_fields'=>true) );
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'option_tree'=>$option_tree,
			'acctoken'=>$acctoken
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function createAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);

		$data = new Features();
		$form = $this->createForm(AdminFeaturesType::class, $data, array('allow_extra_fields'=>true) );
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $data = $form->getData();
			$request_data = $request->request->get('position');
	  		$moveto = $request_data['moveto'];
			if(isset($request_data['parent'])){

				$parent_id = $request_data['parent'];
				$parent_node = $repo->find($parent_id);

				if($moveto=="firstchild"){
	   				$repo->persistAsFirstChildOf($data, $parent_node);
		   		}elseif($moveto=="lastchild"){
	   				$repo->persistAsLastChildOf($data, $parent_node);
		   		}elseif($moveto=="nextsibling"){
	   				$repo->persistAsNextSiblingOf($data, $parent_node);
		   		}elseif($moveto=="prevsibling"){
					$repo->persistAsPrevSiblingOf($data, $parent_node);
				}

			}else{
				//first child
				$features_root_id = $this->container->getParameter('features_root_id');
				$parent_node = $repo->find($features_root_id);
				$repo->persistAsFirstChildOf($data, $parent_node);
			}

			$em->flush();

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}

		$features_root_id = $this->container->getParameter('features_root_id');
		$query = $repo->findDataByRootId($features_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
		$option_tree = $repo->buildTree($query->getArrayResult(), $options);

		$acctoken = $util->getAccessToken();

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'option_tree'=>$option_tree,
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
		$data = $this->getDoctrine()->getRepository(Features::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminFeaturesType::class, $data);
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			'acctoken'=>$acctoken
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(Features::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminFeaturesType::class, $data, array('allow_extra_fields'=>true) );
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			//remove main image
			if($request->get('removefileimage')==1){
				$data->removeImage();
			}
			$em->flush();

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}
		$acctoken = $util->getAccessToken();
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			'acctoken'=>$acctoken
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function move_positionAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$data = $this->getDoctrine()->getRepository(Features::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$features_root_id = $this->container->getParameter('features_root_id');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);

		$query = $repo->findDataByRootId($features_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
		$option_tree = $repo->buildTree($query->getArrayResult(), $options);

		$form = $this->createForm(AdminFeaturesType::class, $data, array('allow_extra_fields'=>true) );
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':move_position.html.twig', array(
			'form'=>$form->createview(),
			'option_tree'=>$option_tree,
			'data'=>$data
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function move_position_updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminFeaturesType::class, $data, array('allow_extra_fields'=>true));

		$request_data = $request->request->get('position');
        $parent_id = $request_data['parent'];
  		$moveto = $request_data['moveto'];

		$parent_node = $repo->find($parent_id);
		if($moveto=="firstchild"){
			$repo->persistAsFirstChildOf($data, $parent_node);
   		}elseif($moveto=="lastchild"){
			$repo->persistAsLastChildOf($data, $parent_node);
   		}elseif($moveto=="nextsibling"){
			$repo->persistAsNextSiblingOf($data, $parent_node);
   		}elseif($moveto=="prevsibling"){
			$repo->persistAsPrevSiblingOf($data, $parent_node);
		}
		$em->flush();

		$util->setUpdateNotice();
		$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
		return $this->redirect($redirect_uri);
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function move_up_positionAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$repo->moveUp($data, 1);

		$util->setUpdateNotice();
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function move_down_positionAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$repo->moveDown($data, 1);

		$util->setUpdateNotice();
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function deleteAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(Features::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$repo->removeFromTree($data);
		$em->clear(); // clear cached nodes

		$util->setRemoveNotice();
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}
}
