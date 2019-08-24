<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\InspirationCategory;
use ProjectBundle\Entity\InspirationCategoryTranslation;

use ProjectBundle\Form\Type\AdminInspirationCategoryType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Intl\Locale;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminInspirationCategoryController extends Controller
{
    const ROUTER_INDEX = 'admin_inspiration_category';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
	const ROUTER_CONTROLLER = 'AdminInspirationCategory';

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
        $repo = $em->getRepository(InspirationCategory::class);

// Add new root
// $insp = new InspirationCategory();
// $insp->translate('en')->setTitle('Inspiration');
// $insp->translate('th')->setTitle('Inspiration');
// $em->persist($insp);
// $insp->mergeNewTranslations();
// $em->flush();

// $insp = $repo->find(1);
// $data = new InspirationCategory();
// $data->translate('en')->setTitle('Cat 1');
// $data->translate('th')->setTitle('Cat 1');
// $data->setParent($insp);
// $em->persist($data);
// $data->mergeNewTranslations();
// $em->flush();
// exit;


		$category_root_id = $this->container->getParameter('inspiration_category_root_id');

        $query = $repo->findDataByRootId($category_root_id)->getQuery();
		$options = $util->getAdminTreeViewWithToppageOptions();
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
        $product_util = $this->container->get('app.product');
		$category_root_id = $this->container->getParameter('inspiration_category_root_id');

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(InspirationCategory::class);

		$query = $repo->findDataByRootId($category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();

        $arr_option_tree = $query->getArrayResult();
        $arr_option_tree_persist_node = $product_util->getArrayProductCategoryPersistNode($arr_option_tree);
		$option_tree = $repo->buildTree($arr_option_tree, $options);

        $data = new InspirationCategory();
		$form = $this->createForm(AdminInspirationCategoryType::class, new InspirationCategory(), array('allow_extra_fields'=>true) );
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'option_tree'=>$option_tree,
            'arr_option_tree_persist_node'=>$arr_option_tree_persist_node,
            'data'=>$data
		));
	}

    /**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function createAction(Request $request)
	{
		$util = $this->container->get('utilities');
        $product_util = $this->container->get('app.product');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(InspirationCategory::class);

		$data = new InspirationCategory();
		$form = $this->createForm(AdminInspirationCategoryType::class, $data, array('allow_extra_fields'=>true) );
		$form->handleRequest($request);

        $category_root_id = $this->container->getParameter('inspiration_category_root_id');

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
				$parent_node = $repo->find($category_root_id);
				$repo->persistAsFirstChildOf($data, $parent_node);
			}

			$em->flush();

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}

		$query = $repo->findDataByRootId($category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
        $arr_option_tree = $query->getArrayResult();
        $arr_option_tree_persist_node = $product_util->getArrayProductCategoryPersistNode($arr_option_tree);
		$option_tree = $repo->buildTree($arr_option_tree, $options);

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'option_tree'=>$option_tree,
            'arr_option_tree_persist_node'=>$arr_option_tree_persist_node,
            'data'=>$data
		));
	}

    /**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function editAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$data = $this->getDoctrine()->getRepository(InspirationCategory::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminInspirationCategoryType::class, $data);

        $option_tree = array();
        $arr_option_tree_persist_node = array();

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
            'option_tree'=>$option_tree,
            'arr_option_tree_persist_node'=>$arr_option_tree_persist_node,
            'data'=>$data
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(InspirationCategory::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminInspirationCategoryType::class, $data, array('allow_extra_fields'=>true) );
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $data = $form->getData();

            //remove main image
			if($request->get('removefileimage')==1){
				$data->removeImage();
			}

			//updateSlug
			$oldSlug = $data->getSlug();
			$data->generateSlug();
			$newSlug = $data->getSlug();
			if ($oldSlug !== $newSlug) {
				$data->setSlug($newSlug);
			}

			$em->flush();

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}

        $option_tree = array();
        $arr_option_tree_persist_node = array();

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
            'option_tree'=>$option_tree,
            'arr_option_tree_persist_node'=>$arr_option_tree_persist_node,
            'data'=>$data
		));
	}

    /**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function move_positionAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
        $product_util = $this->container->get('app.product');
		$data = $this->getDoctrine()->getRepository(InspirationCategory::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$news_category_root_id = $this->container->getParameter('news_category_root_id');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(InspirationCategory::class);

		$query = $repo->findDataByRootId($news_category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
        $arr_option_tree = $query->getArrayResult();
        $arr_option_tree_persist_node = $product_util->getArrayProductCategoryPersistNode($arr_option_tree);
		$option_tree = $repo->buildTree($arr_option_tree, $options);

		$form = $this->createForm(AdminInspirationCategoryType::class, $data, array('allow_extra_fields'=>true) );
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':move_position.html.twig', array(
			'form'=>$form->createview(),
			'option_tree'=>$option_tree,
            'arr_option_tree_persist_node'=>$arr_option_tree_persist_node,
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
		$repo = $em->getRepository(InspirationCategory::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminInspirationCategoryType::class, $data, array('allow_extra_fields'=>true));

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
		$repo = $em->getRepository(InspirationCategory::class);

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
		$repo = $em->getRepository(InspirationCategory::class);

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
		$repo = $em->getRepository(InspirationCategory::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$repo->removeFromTree($data);
		$em->clear(); // clear cached nodes

		$util->setRemoveNotice();
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}
}
