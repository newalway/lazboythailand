<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ProjectBundle\Entity\Product;
use ProjectBundle\Entity\Sku;
use ProjectBundle\Entity\Hashtag;
use ProjectBundle\Entity\Variant;
use ProjectBundle\Entity\VariantOption;
use ProjectBundle\Entity\ProductCategory;
use ProjectBundle\Entity\ProductCategoryTranslation;
use ProjectBundle\Entity\ProductType;
use ProjectBundle\Entity\ProductStyleNumber;

use ProjectBundle\Form\Type\AdminProductType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;

use JMS\SecurityExtraBundle\Annotation\Secure;
use GuzzleHttp\Client;

class AdminProductController extends Controller
{
	const ROUTER_INDEX = 'admin_product';
	const ROUTER_ADD = self::ROUTER_INDEX.'_new';
	const ROUTER_EDIT = self::ROUTER_INDEX.'_edit';
  	const ROUTER_PREFIX = 'product';
	const ROUTER_CONTROLLER = 'AdminProduct';

	protected function getQuerySearchData($arr_query_data, $locale)
	{
		$repository = $this->getDoctrine()->getRepository(Product::class);
    	$query = $repository->findAllDataJoined($arr_query_data, $locale);
		return $query;
	}
	public function prepare_query_data($request)
	{
		$arr_data = $request->query->get('search_data');
		$arr_product_cat = $request->query->get('product_cat');
		//default data
		$arr_query_data = array('q'=>'', 'product_category_id'=>'', 'order_by'=>'product_title', 'sort'=>'ASC');

		if(!empty($arr_data)){
			$arr_query_data['q'] = trim($arr_data['q']);
		}
		if(!empty($arr_product_cat)){
			$arr_query_data['product_category_id'] = $arr_product_cat['parent'];
		}
		$arr_sort_data = $request->query->get('sort_data');
		if(!empty($arr_sort_data['order_by']) && !empty($arr_sort_data['sort'])){
			$arr_query_data['order_by'] = $arr_sort_data['order_by'];
			$arr_query_data['sort'] = $arr_sort_data['sort'];
		}
		return $arr_query_data;
	}


	/**
	 * @Secure(roles="ROLE_EDITOR")
	 */
	public function indexAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$product_util = $this->container->get('app.product');
	    $session = $request->getSession();
	    try {
	    	$acctoken = $util->getAccessToken();
	    } catch(\Exception $e) {
	    	return $this->redirectToRoute('admin_user_generate_token');
	    }

		$em = $this->getDoctrine()->getManager();
		$product_cat_repo = $em->getRepository(ProductCategory::class);
    	$arr_query_data = $this->prepare_query_data($request);

		$product_category_id = null;
		if($arr_query_data['product_category_id']){
			$product_category_id = $arr_query_data['product_category_id'];
			//get children category_id
			$searchFormData['productCategories'] = array($product_category_id);
			$arr_query_data['product_category_id'] = $product_util->getChildrenProductCategoryByCategoryId($searchFormData);
		}

		$query = $this->getQuerySearchData($arr_query_data, $request->getLocale());
		$paginated = $util->setPaginatedOnPagerfanta($query);

	    $util->setBackToUrl();
		$back_url = $util->getBackToUrl(self::ROUTER_INDEX);

		//product category
		$product_category_root_id = $this->container->getParameter('product_category_root_id');
		$product_category_query = $product_cat_repo->findDataByRootId($product_category_root_id)->getQuery();
		$options = $util->getInputSelectTreeViewOptions($product_category_id);
		$option_tree = $product_cat_repo->buildTree($product_category_query->getArrayResult(), $options);

	    return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':index.html.twig', array(
			'paginated' =>$paginated,
			'option_tree'=>$option_tree,
			'back_url'=>$back_url,
			'arr_query_data'=>$arr_query_data
		));
  	}

	/**
	 * @Secure(roles="ROLE_EDITOR")
	 */
	public function newAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$product_util = $this->container->get('app.product');
		$util->setCkAuthorized();
		$acctoken = $util->getAccessToken();
		$locale = $request->getLocale();

		$product_variant_root_id = $this->container->getParameter('product_variant_root_id');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(ProductCategory::class);
		$product_category_node = $repo->find($product_variant_root_id);
		$arr_tree_variant = $repo->getTree($product_category_node);

		$arr_product_type = $product_util->getArrProductType();
		$arr_product_style_number = $product_util->getArrProductStyleNumber();

		## find tree with translation ##
		// $root_variant_qb = $repo->createQueryBuilder('c')
		// 	->join('c.translations', 'ct')
		// 	// ->select('c', 'ct')
		// 	->where('c.id = :id')
		// 	    ->setParameter('id', $product_variant_root_id)
		// 	// ->andWhere("ct.locale = '$locale'")
		// 	->getQuery()
		// 	// ->getArrayResult();
		// 	->getOneOrNullResult();
		// echo 'Number of child : ' . $repo->childCount($root_variant_qb) . "<br/>";
		// $children_qb = $repo->childrenQueryBuilder($root_variant_qb)
		// 	->addSelect('ct')
		// 	->leftJoin('node.translations', 'ct')
		// 	->andWhere("ct.locale = '$locale'")
		// 	// ->andWhere('node.id = :sub_id')
		// 	// ->setParameter('sub_id', 57)
		// 	->getQuery()->getResult();
		// foreach ($children_qb as $chi) {
		// // dump($chi);
		// 	echo $chi->getTitle()." <<< ";
		// }

		// manual create tree
		// $locale = $request->getLocale();
		// $variant_result = $repo->findDataByNodeId($product_variant_root_id)->getQuery()->getOneOrNullResult();
		// $children = $repo->children($variant_result, true, null, 'asc', false);
		// $arr_group_variant = array();
		// foreach ($children as $key => $chi) {
		// 	$arr_group_variant[$key] = array('title' => $chi->getTitle(), '__children'=> array());
		// 	$variant_result_lv1 = $repo->findDataByNodeId($chi->getId())->getQuery()->getOneOrNullResult();
		// 	$children_v1 = $repo->children($variant_result_lv1, true, null, 'asc', false);
		// 	$tmp_arr_children_v1 = array();
		// 	foreach ($children_v1 as $key_lv1 => $chi_lv1) {
		// 		$tmp_arr_children_v1[$key_lv1] = array();
		// 		$tmp_arr_children_v1[$key_lv1] = array('title' => $chi_lv1->getTitle());
		// 	}
		// 	$arr_group_variant[$key]['__children'] = $tmp_arr_children_v1;
		// }

		// $product_category_node = $repo->find($product_variant_root_id);
		// $arrayTree = $repo->childrenHierarchy($product_category_node);

		// $query = $repo->findDataByRootId($product_variant_root_id)->getQuery();
		// $options = $util->getInputSelectTreeViewOptions();
		// $option_tree_html = $repo->buildTree($query->getArrayResult(), $options);


		$data = new Product();
		$current_date = new \DateTime();
		$data->setPublishDate($current_date); //set the default value
		$form = $this->createForm(AdminProductType::class, $data, array('allow_extra_fields'=>true));
    	return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'acctoken'=>$acctoken,
			'arr_tree_variant'=>$arr_tree_variant,
			'arr_product_type'=>$arr_product_type,
			'arr_product_style_number'=>$arr_product_style_number
		));
  	}

	/**
	 * @Secure(roles="ROLE_EDITOR")
	 */
	public function createAction(Request $request)
	{
    	$util = $this->container->get('utilities');
		$product_util = $this->container->get('app.product');
		$acctoken = $util->getAccessToken();
		$em = $this->getDoctrine()->getManager();

		$data = new Product();
	    $form = $this->createForm(AdminProductType::class, $data, array('allow_extra_fields'=>true));
	    $form->handleRequest($request);

    	if ($form->isSubmitted() && $form->isValid()) {
			//create product
			$em->persist($data);
	    	$em->flush();

			//product data
			$frm_product = $request->request->get('admin_product');

			//save product image size s,m,l
			$product_util->saveProductImageSize($data, null);

			//save image_gallery
			$product_util->saveProductImageGallery($data);

			//validate inventory with button "add" and "set"
			// $product_util->saveProductInventoryAdjustment($data, $frm_product);

			//weight grams
			$product_util->saveProductWeightGrams($data, $frm_product);

			//tags
			$product_util->saveProductHashtags($data, $frm_product);

			//variants
			$product_util->saveProductVariants($data, $frm_product);

			$util->setCreateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
    	}

		$product_variant_root_id = $this->container->getParameter('product_variant_root_id');
		$repo = $em->getRepository(ProductCategory::class);
		$product_category_node = $repo->find($product_variant_root_id);
		$arr_tree_variant = $repo->getTree($product_category_node);

		$arr_product_type = $product_util->getArrProductType();
		$arr_product_style_number = $product_util->getArrProductStyleNumber();

    	return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':new.html.twig', array(
			'form'=>$form->createView(),
			'acctoken'=>$acctoken,
			'arr_tree_variant'=>$arr_tree_variant,
			'arr_product_type'=>$arr_product_type,
			'arr_product_style_number'=>$arr_product_style_number
		));
  	}

	/**
	 * @Secure(roles="ROLE_EDITOR")
	 */
	public function editAction(Request $request)
	{
    	$util = $this->container->get('utilities');
		$product_util = $this->container->get('app.product');
		$util->setCkAuthorized();
		$acctoken = $util->getAccessToken();

		$data = $this->getDoctrine()->getRepository(Product::class)->find($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		$product_id = $data->getId();
		$form = $this->createForm(AdminProductType::class, $data, array('allow_extra_fields'=>true));

		// $have_variants = $product_util->isVariants($data);

		$product_variant_root_id = $this->container->getParameter('product_variant_root_id');
		$em = $this->getDoctrine()->getManager();
		$repo = $em->getRepository(ProductCategory::class);
		$product_category_node = $repo->find($product_variant_root_id);
		$arr_tree_variant = $repo->getTree($product_category_node);

		$arr_product_type = $product_util->getArrProductType();
		$arr_product_style_number = $product_util->getArrProductStyleNumber();

    	return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			'acctoken'=>$acctoken,
			'product'=>$data,
			'arr_tree_variant'=>$arr_tree_variant,
			'arr_product_type'=>$arr_product_type,
			'arr_product_style_number'=>$arr_product_style_number
		));
  	}

	/**
	 * @Secure(roles="ROLE_EDITOR")
	 */
	public function updateAction(Request $request)
	{
    	$util = $this->container->get('utilities');
		$product_util = $this->container->get('app.product');

    	$em = $this->getDoctrine()->getManager();
		$acctoken = $util->getAccessToken();

		$data = $em->getRepository(Product::class)->findOneById($request->get('id'));
		if (!$data) { throw $this->createNotFoundException('No data found'); }

		// $admin_product = $request->get('admin_product');
		$update_variant_sku = $request->get('update_variant_sku');
		// $variant_sku = $request->get('variant_sku');

// $variant_option_basic_price = $request->get('variant_option_basic_price');
// $variant_option_basic_compare_at_price = $request->get('variant_option_basic_compare_at_price');
// print_r($variant_option_basic_price);
// print_r($variant_option_basic_compare_at_price);
// exit;


		$product_id = $data->getId();
		$ori_image = $data->getImage();
	    $form = $this->createForm(AdminProductType::class, $data, array('allow_extra_fields'=>true));
	    $form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid())
		{
			if($request->get('removefileimage')==1){
				$data->removeImage();
			}
			if($request->get('removefileImageDimension')==1){
				$data->removeImageDimension();
			}

			$em->flush();

			//product data
			$frm_product = $request->request->get('admin_product');

			//save product image size s,m,l
			$product_util->saveProductImageSize($data, $ori_image);

			//save image_gallery
			$product_util->saveProductImageGallery($data);

			//validate inventory with button "add" and "set"
			// $product_util->saveProductInventoryAdjustment($data, $frm_product);

			//weight grams
			$product_util->saveProductWeightGrams($data, $frm_product);

			//tags
			$product_util->saveProductHashtags($data, $frm_product);

			//update variants
			$product_util->updateProductVariants($data);

			//create variants
			$product_util->saveProductVariants($data, $frm_product);

			//save product inventory status
			$product_util->skuSaveProductInventoryStatus($data);

			$util->setUpdateNotice();
			$redirect_uri = $util->getRedirectUriSaveBtn($form, $data, self::ROUTER_INDEX, self::ROUTER_ADD, self::ROUTER_EDIT);
			return $this->redirect($redirect_uri);
    	}

		$product_variant_root_id = $this->container->getParameter('product_variant_root_id');
		$repo = $em->getRepository(ProductCategory::class);
		$product_category_node = $repo->find($product_variant_root_id);
		$arr_tree_variant = $repo->getTree($product_category_node);

		$arr_product_type = $product_util->getArrProductType();
		$arr_product_style_number = $product_util->getArrProductStyleNumber();

    	return $this->render('ProjectBundle:'.self::ROUTER_CONTROLLER.':edit.html.twig', array(
			'form'=>$form->createview(),
			'acctoken'=>$acctoken,
			'product'=>$data,
			'arr_tree_variant'=>$arr_tree_variant,
			'arr_product_type'=>$arr_product_type,
			'arr_product_style_number'=>$arr_product_style_number
		));
  	}

	/**
	 * @Secure(roles="ROLE_EDITOR")
	 */
	public function deleteAction(Request $request)
	{
    	$util = $this->container->get('utilities');
		$em = $this->getDoctrine()->getManager();

    	$data = $em->getRepository(Product::class)->find($request->get('id'));
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
				$data = $em->getRepository(Product::class)->find($data_id);
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
				$data = $em->getRepository(Product::class)->find($data_id);
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
				$data = $em->getRepository(Product::class)->find($data_id);
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
		$datas = $this->getQuerySearchData($arr_query_data, $request->getLocale())->getQuery()->getResult();
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
				$data = $em->getRepository(Product::class)->find($data_id);
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
