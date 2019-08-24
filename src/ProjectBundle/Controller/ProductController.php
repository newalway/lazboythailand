<?php

namespace ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ProjectBundle\Entity\User;
use ProjectBundle\Entity\Product;
use ProjectBundle\Entity\Brand;
use ProjectBundle\Entity\Equipment;
use ProjectBundle\Entity\AgeGroup;
use ProjectBundle\Entity\CustomerGroup;
use ProjectBundle\Entity\Muscle;
use ProjectBundle\Entity\Showroom;
use ProjectBundle\Entity\Authentication;
use ProjectBundle\Entity\ProductOptionCategory;
use ProjectBundle\Entity\ProductOption;
use ProjectBundle\Entity\ProductCategory;
use ProjectBundle\Entity\BannerAds;
use ProjectBundle\Entity\Review;
use ProjectBundle\Entity\SettingOption;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Intl\Locale;

use ProjectBundle\Form\Type\Product\ProductSearchType;
use ProjectBundle\Form\Type\Product\ProductNonShopOnlineSearchType;
use ProjectBundle\Form\Type\Product\AddToCartType;
use ProjectBundle\Form\Type\ReviewType;


class ProductController extends Controller
{
	private $pathCategoryId;
	private $currIsShopOnline;
	private $arrUrlParams;
	private $arrUrlMobileParams;

	public function indexAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$product_util = $this->container->get('app.product');
		$em = $this->getDoctrine()->getManager();
		$repository = $em->getRepository(Product::class);
		$locale = $request->getLocale();
		$session = $request->getSession();


		$route_name = $request->get('_route');
		$arr_route_name_product_shop_online = $this->container->getParameter('arr_route_name_product_shop_online');

		if (in_array($route_name, $arr_route_name_product_shop_online)){
			//online shop
			$this->currIsShopOnline = true;
			$searchForm = $this->createForm(ProductSearchType::class);
		}else{
			//product
			$this->currIsShopOnline = false;
			$searchForm = $this->createForm(ProductNonShopOnlineSearchType::class);
		}

		$searchFormData = $request->query->get($searchForm->getName('product_search'));
		$searchForm->handleRequest($request);
		$data = $searchForm->getData();

		$arr_url_params = $request->query->all();

		$category = null;
		$arr_path_category_id = array();
		if($request->get('cate_id')){
			$product_cat_id = $request->get('cate_id');
			//get children category_id
			$searchFormData['productCategories'] = array($product_cat_id);
			$data['product_category_id'] = $product_util->getChildrenProductCategoryByCategoryId($searchFormData);
			//get path parent category_id
			$product_cat_repo = $em->getRepository(ProductCategory::class);
			$category = $product_cat_repo->find($request->get('cate_id'));
			$path = $product_cat_repo->getPath($category);
			foreach ($path as $pk => $p) {
				$arr_path_category_id[$pk] = $p->getId();
			}
		}

		$limitPages = $this->container->getParameter('max_per_page_latest_product');
		$limitPerPage = (isset($data['limitPerPage'])) ? $data['limitPerPage'] : $limitPages;
		if (in_array($route_name, $arr_route_name_product_shop_online)){
			//online shop
			$query = $repository->findAllActiveShopOnlineData($data, $locale);
		}else{
			//product
			$query = $repository->findAllActiveData($data, $locale);
		}
		$paginated = $util->setPaginatedOnPagerfanta($query, $limitPerPage);

		return $this->render('ProjectBundle:'.$this->container->getParameter('view_product').':index.html.twig', array(
			'paginated'=>$paginated,
			'search_form' =>$searchForm->createView(),
			'category'=>$category,
			'arr_path_category_id'=>$arr_path_category_id,
			'arr_query' => $data,
			'route_name'=>$route_name,
			'currIsShopOnline'=>$this->currIsShopOnline,
			'arr_url_params'=>$arr_url_params
		));
	}

	public function detailAction(Request $request)
	{
		$util = $this->container->get('utilities');
		$product_util = $this->container->get('app.product');
		$session = $request->getSession();
		$em = $this->getDoctrine();
		$locale = $request->getLocale();

		//get array product option from query string
		$product_options_url_encode = $request->get('product_options_id');
		$arr_product_options_query_url = $product_util->decodeQueryURL($product_options_url_encode);

		$arr_product = $em->getRepository(Product::class)
			->getActiveDataById($request->get('id'), $request->getLocale())
			->getQuery()
			->getSingleResult();

		if (!$arr_product) { throw $this->createNotFoundException('No data found'); }
		try {
			//member
			$acctoken = $util->getAccessToken();
		} catch(\Exception $e) {
			//non member
			$acctoken = '';
		}
		//get product object
		$product = $arr_product[0];

		//get product categories
		$product_categories = $product->getProductCategories();

		//get variant data
		$arr_variant_data = $product_util->setArrProductVariantsData($product);
		$arr_sku_variant_data = $arr_variant_data['arr_sku_variant_data'];
		$arr_variant_option_data = $arr_variant_data['arr_variant_option_data'];
		$is_variant = $product_util->isVariantsFromArrVariantData($arr_sku_variant_data['variant_data']);

		//get product option category
		$arr_product_options = $product_util->setArrProductOptionsData($product, $arr_product_options_query_url);

		//get showrooms
		/*
		$showrooms = $em->getRepository(Showroom::class)
						->getShowroomByProduct($product, $request->getLocale())
						->setMaxResults(3)
						->getArrayResult();
		*/

		//get tags
		$arr_tags = array();
		$hash_tags = $product->getHashtags();
		foreach ($hash_tags as $key => $hash_tag) {
			$arr_tags[$key] = $hash_tag->getTitle();
		}

		//get product related
		$products_relateds = $em->getRepository(Product::class)->getActiveDataByProductsRelated($product)->setMaxResults(6)->getQuery()->getResult();

		//get complete the set
		$products_complete_set = array();
		$product_style_number = $product->getProductStyleNumber();
		if($product_style_number){
			$products_complete_set = $em->getRepository(Product::class)->getActiveDataCompleteSetByProduct($product)->setMaxResults(6)->getQuery()->getResult();
		}

		$form = $this->createForm(AddToCartType::class);
		$geolocation_api_key = $util->getGeolocationApiKey();

		//get average rating
		$arr_rating = $util->getRattingData($product);
		$review = new Review();
		$review_form = $this->createForm(ReviewType::class, $review, array('allow_extra_fields'=>true));
		$util->setCookieUser();
		$user_session = $util->getCookieUser();

		//get delivery information
		$repo_setting_option = $em->getRepository(SettingOption::class);
		$delivery_information = $repo_setting_option->getDataByOptionName('delivery_information_'.$locale)->getQuery()->getOneOrNullResult();
		$warranty_condition = $repo_setting_option->getDataByOptionName('warranty_condition_'.$locale)->getQuery()->getOneOrNullResult();
		$replacement_condition = $repo_setting_option->getDataByOptionName('replacement_condition_'.$locale)->getQuery()->getOneOrNullResult();

		return $this->render('ProjectBundle:'.$this->container->getParameter('view_product').':detail.html.twig', array(
			'form'=>$form->createView(),
			'data'=>$product,
			'arr_product'=>$arr_product,
			'arr_sku_variant_data'=>$arr_sku_variant_data,
			'arr_variant_option_data'=>$arr_variant_option_data,
			'is_variant'=>$is_variant,
			// 'showrooms'=>$showrooms,
			'products_relateds'=>$products_relateds,
			'products_complete_set'=>$products_complete_set,
			'arr_tags'=>$arr_tags,
			'geolocation_api_key'=>$geolocation_api_key,
			'arr_product_options'=>$arr_product_options,
			'product_categories'=>$product_categories,
			'review_form' =>$review_form->createView(),
			'acctoken' => $acctoken,
			'user_session' => $user_session,
			'arr_rating'=>$arr_rating,
			'delivery_information'=>$delivery_information,
			'warranty_condition'=>$warranty_condition,
			'replacement_condition'=>$replacement_condition
		));
	}

	public function _sidebar_menuAction(Request $request, $obj_category=null, $arr_path_category_id=array(), $arr_query = array(), $route_name=null, $arr_url_params=array())
	{
		$util = $this->container->get('utilities');
		$locale = $request->getLocale();
		$session = $request->getSession();
		$em = $this->getDoctrine();
		$this->pathCategoryId = $arr_path_category_id;
		$this->arrUrlParams = $arr_url_params;

		$searchForm = $this->createForm(ProductSearchType::class);
		$searchForm->handleRequest($request);
		if(isset($arr_query['searchBox'])){
			$searchForm->get('searchBox')->setData($arr_query['searchBox']);
		}
		if(isset($arr_query['startprice'])){
			$searchForm->get('startprice')->setData($arr_query['startprice']);
		}
		if(isset($arr_query['endprice'])){
			$searchForm->get('endprice')->setData($arr_query['endprice']);
		}
		if(isset($arr_query['shop_by'])){
			$searchForm->get('shop_by')->setData($arr_query['shop_by']);
		}
		if(isset($arr_query['ddlPriceSort'])){
			$searchForm->get('ddlPriceSort')->setData($arr_query['ddlPriceSort']);
		}
		if(isset($arr_query['ddlPriceSortMobile'])){
			$searchForm->get('ddlPriceSortMobile')->setData($arr_query['ddlPriceSortMobile']);
		}

		$arr_route_name_product_shop_online = $this->container->getParameter('arr_route_name_product_shop_online');
		if (in_array($route_name, $arr_route_name_product_shop_online)){
			//shop online
			$this->currIsShopOnline = true;
		}else{
			$this->currIsShopOnline = false;
		}

		//Product Category Data
        $product_category_root_id = $this->container->getParameter('product_category_root_id');
        $repo_product_category = $em->getRepository(ProductCategory::class);
        $product_category = $repo_product_category->findDataByRootId($product_category_root_id,$locale)->getQuery();
        $options = array(
            'decorate' => true,
			'rootOpen' => function($rOpen) {
                if($rOpen[0]['lvl'] == 1){
					$html = '';
                }else{
					$html = '<ul>';
				}
				return $html;
            },
			'rootClose' => function($rClose) {
                if($rClose[0]['lvl'] == 1){
                    $html = '';
                }else{
					$html = '</ul>';
				}
				return $html;
            },
            'childOpen' => function($cOpen) {
				$id = $cOpen['id'];
				$level = $cOpen['lvl'];
				$title = $cOpen['translations'][Locale::getDefault()]['title'];

				$active_class = '';
				$class_show = '';
				$active_expanded = "collapsed";
				if(sizeof($this->pathCategoryId)){
					if (in_array($id, $this->pathCategoryId)) {
					    $active_class = "active";
						$class_show = "show";
						$active_expanded = "";
					}
				}

				if($level == 1){
					$html = '<div class="panel panel-custom">
								<div class="panel-custom-heading" id="'.$id.'Headingundefined" role="tab">
									<div class="panel-custom-title">
										<a class="'.$active_expanded.' '.$active_class.'" role="button" data-toggle="collapse" data-parent="#'.$id.'" href="#'.$id.'Collapseundefined" aria-controls="'.$id.'Collapseundefined">
											'.$title.'
										</a>
									</div>
								</div>
								<div class="panel-custom-collapse collapse '.$class_show.'" id="'.$id.'Collapseundefined" role="tabpanel" aria-labelledby="'.$id.'Headingundefined">
									<div class="panel-custom-body">';
                }else{
					$html = '<li class="li-lvl lvl'.$level.' lvl-id-'.$id.' '.$active_class.'">';
				}
				return $html;
             },
            'childClose' => function($cClose) {
				if($cClose['lvl'] == 1){
                	$html = '</div></div></div>';
                }else{
					$html = '</li>';
				}
				return $html;
             },
            'nodeDecorator' => function($node) {
				$title = $node['translations'][Locale::getDefault()]['title'];
				if($node['lvl'] == 1){
					$html = '';
				}else{
					if($this->currIsShopOnline){
						$link_route_name = 'product_shop_online_category';
					}else{
						$link_route_name = 'product_category';
					}
					//set arr url prarmeters
					$this->arrUrlParams['cate_id'] = $node['id'];
					$this->arrUrlParams['slug'] = $node['slug'];

					$url = $this->container->get('router')->generate($link_route_name, $this->arrUrlParams);
	                // $url = $this->container->get('router')->generate($link_route_name, array('cate_id'=>$node['id'], 'slug'=>$node['slug']));
	                $html = '<a href="'.$url.'">'.$title.'</a>';
				}
                return $html;
            }
        );
        $tree_product_category = $repo_product_category->buildTree($product_category->getArrayResult(), $options);

		//Banner left side ads
		$product_left_side_ad = $this->container->getParameter('con_banner_product_left_side_ad');
        $banner_product_left_side_ads = $em->getRepository(BannerAds::class)->findAllDataWithBannerGroup($product_left_side_ad, $locale)->getQuery()->getResult();

		return $this->render('ProjectBundle:'.$this->container->getParameter('view_product').':_sidebar_menu.html.twig', array(
			'banner_product_left_side_ads'=>$banner_product_left_side_ads,
			'tree_product_category'=>$tree_product_category,
			'search_form' =>$searchForm->createView(),
			'arr_query_data' =>$arr_query,
			'currIsShopOnline'=>$this->currIsShopOnline,
			'obj_category'=>$obj_category
		));
	}

	public function _sidebar_menu_filter_for_mobileAction(Request $request, $obj_category=null, $arr_path_category_id=array(), $arr_query = array(), $route_name=null, $arr_url_params=array())
	{
		$util = $this->container->get('utilities');
		$locale = $request->getLocale();
		$session = $request->getSession();
		$em = $this->getDoctrine();
		$this->pathCategoryId = $arr_path_category_id;
		$this->arrUrlMobileParams = $arr_url_params;

		// $route_name = $request->get('_route');
		// $arr_route_name_product_shop_online = $this->container->getParameter('arr_route_name_product_shop_online');
		// if (in_array($route_name, $arr_route_name_product_shop_online)){
		// 	$searchForm = $this->createForm(ProductSearchType::class);
		// }else{
		// 	$searchForm = $this->createForm(ProductNonShopOnlineSearchType::class);
		// }

		// $searchForm = $this->createForm(ProductSearchType::class);
		$arr_route_name_product_shop_online = $this->container->getParameter('arr_route_name_product_shop_online');
		if (in_array($route_name, $arr_route_name_product_shop_online)){
			//shop online
			$this->currIsShopOnline = true;
			$searchForm = $this->createForm(ProductSearchType::class);
		}else{
			$this->currIsShopOnline = false;
			$searchForm = $this->createForm(ProductNonShopOnlineSearchType::class);
		}

		$searchForm->handleRequest($request);
		if(isset($arr_query['searchBox'])){
			$searchForm->get('searchBox')->setData($arr_query['searchBox']);
		}
		if(isset($arr_query['startprice'])){
			$searchForm->get('startprice')->setData($arr_query['startprice']);
		}
		if(isset($arr_query['endprice'])){
			$searchForm->get('endprice')->setData($arr_query['endprice']);
		}
		if(isset($arr_query['shop_by'])){
			$searchForm->get('shop_by')->setData($arr_query['shop_by']);
		}
		if(isset($arr_query['ddlPriceSort'])){
			$searchForm->get('ddlPriceSort')->setData($arr_query['ddlPriceSort']);
		}
		if(isset($arr_query['ddlPriceSortMobile'])){
			$searchForm->get('ddlPriceSortMobile')->setData($arr_query['ddlPriceSortMobile']);
		}

		//Product Category Data
        $product_category_root_id = $this->container->getParameter('product_category_root_id');

        $repo_product_category = $em->getRepository(ProductCategory::class);
        $product_category = $repo_product_category->findDataByRootId($product_category_root_id,$locale)->getQuery();
        $options = array(
            'decorate' => true,
			'rootOpen' => function($rOpen) {
                if($rOpen[0]['lvl'] == 1){
					$html = '';
                }else{
					$html = '<ul>';
				}
				return $html;
            },
			'rootClose' => function($rClose) {
                if($rClose[0]['lvl'] == 1){
                    $html = '';
                }else{
					$html = '</ul>';
				}
				return $html;
            },
            'childOpen' => function($cOpen) {
				$id = $cOpen['id'];
				$level = $cOpen['lvl'];
				$title = $cOpen['translations'][Locale::getDefault()]['title'];

				$active_class = '';
				$class_show = '';
				$active_expanded = "collapsed";
				if(sizeof($this->pathCategoryId)){
					if (in_array($id, $this->pathCategoryId)) {
					    $active_class = "active";
						$class_show = "show";
						$active_expanded = "";
					}
				}

				if($level == 1){
					$html = '<div class="panel panel-custom">
								<div class="panel-custom-heading" id="filter-'.$id.'Headingundefined" role="tab">
									<div class="panel-custom-title">
										<a class="'.$active_expanded.' '.$active_class.'" role="button" data-toggle="collapse" data-parent="#filter-'.$id.'" href="#filter-'.$id.'Collapseundefined" aria-controls="filter-'.$id.'Collapseundefined" aria-expanded="false">
											'.$title.'
										</a>
									</div>
								</div>
								<div class="panel-custom-collapse collapse '.$class_show.'" id="filter-'.$id.'Collapseundefined" role="tabpanel" aria-labelledby="filter-'.$id.'Headingundefined">
									<div class="panel-custom-body">';
                }else{
					$html = '<li class="li-lvl lvl'.$level.' lvl-id-filter-'.$id.' '.$active_class.'">';
				}
				return $html;
             },
            'childClose' => function($cClose) {
				if($cClose['lvl'] == 1){
                	$html = '</div></div></div>';
                }else{
					$html = '</li>';
				}
				return $html;
             },
            'nodeDecorator' => function($node) {
				$title = $node['translations'][Locale::getDefault()]['title'];
				if($node['lvl'] == 1){
					$html = '';
				}else{
					if($this->currIsShopOnline){
						$link_route_name = 'product_shop_online_category';
					}else{
						$link_route_name = 'product_category';
					}
					//set arr url prarmeters
					$this->arrUrlMobileParams['cate_id'] = $node['id'];
					$this->arrUrlMobileParams['slug'] = $node['slug'];

	                $url = $this->container->get('router')->generate($link_route_name, $this->arrUrlMobileParams);
					// $url = $this->container->get('router')->generate($link_route_name, array('cate_id'=>$node['id'], 'slug'=>$node['slug']));
	                $html = '<a href="'.$url.'">'.$title.'</a>';
				}
                return $html;
            }
        );
        $tree_product_category = $repo_product_category->buildTree($product_category->getArrayResult(), $options);

		return $this->render('ProjectBundle:'.$this->container->getParameter('view_product').':_sidebar_menu_filter_for_mobile.html.twig', array(
			'tree_product_category'=>$tree_product_category,
			'search_form' =>$searchForm->createView(),
			'arr_query_data' =>$arr_query,
			'currIsShopOnline'=>$this->currIsShopOnline,
			'obj_category'=>$obj_category
		));
	}

	public function _bannerProductCategoryAction(Request $request, $category_id=null, $banner_name=null)
	{
		$util = $this->container->get('utilities');
		$locale = $request->getLocale();
		$session = $request->getSession();
		$em = $this->getDoctrine();
		$repo_product_category = $em->getRepository(ProductCategory::class);

		$product_category = null;
		if($category_id != null){
			$product_category = $repo_product_category->findDataByNodeId($category_id)->getQuery()->getResult();
		}

		$banner_top_ad = null;
		if($banner_name){
			$product_top_ad = $this->container->getParameter('con_banner_product_top_ad');
			$banner_ad_repo = $this->getDoctrine()->getManager()->getRepository(BannerAds::class);
	        $banner_top_ad = $banner_ad_repo->findOneByBannerGroup($banner_name);
		}

		return $this->render('ProjectBundle:'.$this->container->getParameter('view_product').':_banner_product_category.html.twig', array(
			'product_category'=>$product_category,
			'category_id' =>$category_id,
			'banner_top_ad' => $banner_top_ad
		));
	}

}
