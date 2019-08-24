<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\NewsCategory;
use ProjectBundle\Entity\NewsCategoryTranslation;

use ProjectBundle\Form\Type\AdminNewsCategoryType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Intl\Locale;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminNewsCategoryController extends Controller
{
	const ROUTER_INDEX = 'admin_news_category';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
	const ROUTER_CONTROLLER = 'AdminNewsCategory';

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
		$repo = $em->getRepository(NewsCategory::class);
		$news_category_root_id = $this->container->getParameter('news_category_root_id');

// // find and update
// $fruits = $repo->find(31);
// $orange = new NewsCategory();
// $orange->translate('en')->setTitle('Orange');
// $orange->translate('th')->setTitle('ส้ม');
// $orange->setParent($fruits);
// $em->persist($orange);
// $orange->mergeNewTranslations();
// $em->flush();

// // Add new root
// $clothes = new NewsCategory();
// $clothes->translate('en')->setTitle('Clothes');
// $clothes->translate('th')->setTitle('เสื้อผ้า');
// $tshirt = new NewsCategory();
// $tshirt->translate('en')->setTitle('T-Shirt');
// $tshirt->translate('th')->setTitle('เสื้อยืด');
// $tshirt->setParent($clothes);
// $em->persist($clothes);
// $em->persist($tshirt);
// $clothes->mergeNewTranslations();
// $tshirt->mergeNewTranslations();
// $em->flush();

		// $options = $util->getHtmlTreeViewOptions();

		$query = $repo->findDataByRootId($news_category_root_id)->getQuery();
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
		$news_category_root_id = $this->container->getParameter('news_category_root_id');

		// entities tree
		// $em = $this->getDoctrine()->getManager();
		// $em->getConfiguration()->addCustomHydrationMode('tree', 'Gedmo\Tree\Hydrator\ORM\TreeObjectHydrator');
		// $repo = $em->getRepository(NewsCategory::class);
		// $tree = $repo->createQueryBuilder('node')->getQuery()
    	// 	->setHint(\Doctrine\ORM\Query::HINT_INCLUDE_META_COLUMNS, true)
    	// 	->getResult('tree');

		// get children from node
		// $news_category_node = $repo->find($news_category_root_id);
		// $arrayTree = $repo->childrenHierarchy($news_category_node);

		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(NewsCategory::class);

		// $query = $repo->findChildrenByParentId(31)->getQuery();
		$query = $repo->findDataByRootId($news_category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
		$option_tree = $repo->buildTree($query->getArrayResult(), $options);

		$form = $this->createForm(AdminNewsCategoryType::class, new NewsCategory(), array('allow_extra_fields'=>true) );
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'option_tree'=>$option_tree
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function createAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(NewsCategory::class);

		$data = new NewsCategory();
		$form = $this->createForm(AdminNewsCategoryType::class, $data, array('allow_extra_fields'=>true) );
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
				$news_category_root_id = $this->container->getParameter('news_category_root_id');
				$parent_node = $repo->find($news_category_root_id);
				$repo->persistAsFirstChildOf($data, $parent_node);
			}

			$em->flush();

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
		}

		$news_category_root_id = $this->container->getParameter('news_category_root_id');
		$query = $repo->findDataByRootId($news_category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
		$option_tree = $repo->buildTree($query->getArrayResult(), $options);

		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'option_tree'=>$option_tree
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function editAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$data = $this->getDoctrine()->getRepository(NewsCategory::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminNewsCategoryType::class, $data);
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function updateAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

		$data = $em->getRepository(NewsCategory::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminNewsCategoryType::class, $data, array('allow_extra_fields'=>true) );
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			// $data = $form->getData();

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
		return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview()
		));
	}

	/**
	* @Secure(roles="ROLE_EDITOR")
	*/
	public function move_positionAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$util->setCkAuthorized();
		$data = $this->getDoctrine()->getRepository(NewsCategory::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$news_category_root_id = $this->container->getParameter('news_category_root_id');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(NewsCategory::class);

		$query = $repo->findDataByRootId($news_category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions();
		$option_tree = $repo->buildTree($query->getArrayResult(), $options);

		$form = $this->createForm(AdminNewsCategoryType::class, $data, array('allow_extra_fields'=>true) );
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
		$repo = $em->getRepository(NewsCategory::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$form = $this->createForm(AdminNewsCategoryType::class, $data, array('allow_extra_fields'=>true));

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
		$repo = $em->getRepository(NewsCategory::class);

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
		$repo = $em->getRepository(NewsCategory::class);

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
		$repo = $em->getRepository(NewsCategory::class);

		$data = $repo->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$repo->removeFromTree($data);
		$em->clear(); // clear cached nodes

		$util->setRemoveNotice();
		return $this->redirect($util->getBackToUrl(self::ROUTER_INDEX));
	}
}
