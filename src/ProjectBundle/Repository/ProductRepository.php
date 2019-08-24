<?php

namespace ProjectBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Intl\Locale;

use ProjectBundle\Entity\ProductCategory;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class ProductRepository extends EntityRepository implements ContainerAwareInterface
{
    private $qb;

    /**
     * @var ContainerInterface
     */
    private $container;
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function findAllData()
    {
        $this->qb =  $this->createQueryBuilder('p')
                ->orderBy('p.position', 'ASC')
                ->addOrderBy('p.createdAt', 'DESC');
        return $this->qb;
    }

    public function findDataById($id)
    {
        $this->find($id);
        return $this;
    }

    public function selectProductSkuData($locale=false)
    {
        $locale = ($locale) ? $locale : Locale::getDefault();
  		$this->qb = $this->createQueryBuilder('p');
        // Doctrine\ORM\Query\Expr::WITH

        $this->qb->select('p', 'pt', 'ptype', 'pstyle')
            ->leftjoin('p.skus', 'sku', "WITH", 'sku.status = 1')
            ->leftjoin('p.translations', 'pt', "WITH", "pt.locale='$locale'")
            ->leftjoin('p.productType', 'ptype')
            ->leftjoin('p.productStyleNumber', 'pstyle')
            ->groupBy('p.id');

        // ->andWhere("pt.locale = '$locale'")
        // $this->qb->addSelect('pc', 'pct')
        //      ->leftjoin('p.productCategories', 'pc')
        //      ->leftjoin('pc.translations', 'pct');
        //      ->andWhere('pct.locale = :locale')->setParameter('locale', $locale);

        $this->setSelectPriceData();
    }

    public function setSelectPriceData()
    {
        $this->qb->addSelect("COUNT(distinct sku.id) as v_count")
        ->addSelect("(SELECT SUM( ss1.inventoryQuantity) as total
                        FROM ProjectBundle\Entity\Sku ss1
                        WHERE ss1.product = p.id
                            AND ss1.inventoryPolicyStatus = 1
                            AND ss1.status = 1)
                     AS v_inventory_quantity ")
        ->addSelect("SUM(distinct sku.defaultOption) as v_is_default_option")
        ->addSelect("(SELECT ss2.price
                        FROM ProjectBundle\Entity\Sku ss2
                        WHERE ss2.product = p.id
                            AND ss2.defaultOption = 1
                            AND ss2.status = 1)
                     AS v_default_price ")
        ->addSelect("(SELECT ss3.compareAtPrice
                        FROM ProjectBundle\Entity\Sku ss3
                        WHERE ss3.product = p.id
                            AND ss3.defaultOption = 1
                            AND ss3.status = 1)
                     AS v_default_compare_at_price ")
        ->addSelect("sku.price as v_price")
        ->addSelect("sku.compareAtPrice as v_compare_at_price")
        ->addSelect("(SELECT MIN(ss4.price)
                        FROM ProjectBundle\Entity\Sku ss4
                        WHERE ss4.product = p.id
                            AND ss4.status = 1)
                     AS v_starting_price")

         ->addSelect("(SELECT MIN(ss5.compareAtPrice)
                         FROM ProjectBundle\Entity\Sku ss5
                         WHERE ss5.product = p.id
                             AND ss5.status = 1
                             AND ss5.price = ( SELECT MIN(ss6.price) FROM ProjectBundle\Entity\Sku ss6 WHERE ss6.product = p.id AND ss6.status = 1  )
                         )
                      AS v_starting_compare_at_price")
                      ;
    }

    public function setOrderBy($sort='ASC')
    {
        $this->qb->addOrderBy('ptype.title', $sort)
                ->addOrderBy('pstyle.title', $sort)
                ->addOrderBy('pt.title', $sort)
                ->addOrderBy('p.createdAt', 'DESC');

        // ->addOrderBy('p.position', $sort)
    }

    public function setJoinProductCategory($locale=false)
    {
        $locale = ($locale) ? $locale : Locale::getDefault();
        $this->qb->leftjoin('p.productCategories', 'pc')
                ->leftjoin('pc.translations', 'pct', "WITH", "pct.locale='$locale'");

        // $this->qb->addSelect('pc', 'pct');
        // $this->qb->leftjoin('p.productCategories', 'pc')
        //         ->leftjoin('pc.translations', 'pct', "WITH", "pct.locale='$locale'");

        // $locale = ($locale) ? $locale : Locale::getDefault();
        // $this->qb->addSelect('pc', 'pct')
        //     ->leftjoin('p.productCategories', 'pc')
        //     ->leftjoin('pc.translations', 'pct')
        //     ->andWhere('pct.locale = :locale')
        //     ->setParameter('locale', $locale);
    }

    public function setPublic($locale=false)
    {
        $this->qb->andWhere('NOW() >= p.publishDate')
                ->andWhere('p.status = 1');

        $this->setJoinProductCategory($locale);

        // $locale = ($locale) ? $locale : Locale::getDefault();
        // $this->qb->addSelect('pc', 'pct')
        //     ->leftjoin('p.productCategories', 'pc')
        //     ->leftjoin('pc.translations', 'pct')
        //     ->andWhere('pct.locale = :locale')
        //     ->setParameter('locale', $locale);
    }

    public function findProductsDiscountsByDiscountIdDataJoined($discount_id, $locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setOrderBy();
        $this->qb->innerjoin('p.discounts', 'd')
            ->andWhere('d.id = :discount_id')
            ->setParameter('discount_id', $discount_id);
        return $this->qb;
    }

    public function findProductsPromotionsByPromotionIdDataJoined($promotion_id, $locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setOrderBy();
        $this->qb->innerjoin('p.promotions', 'd')
            ->andWhere('d.id = :promotion_id')
            ->setParameter('promotion_id', $promotion_id);
        return $this->qb;
    }

    public function findProductsInspirationsByInspirationIdDataJoined($inspiration_id, $locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setOrderBy();
        $this->qb->innerjoin('p.inspirations', 'i')
            ->andWhere('i.id = :inspiration_id')
            ->setParameter('inspiration_id', $inspiration_id);
        return $this->qb;
    }

    public function findProductsFeaturessByFeaturesIdDataJoined($features_id, $locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setOrderBy();
        $this->qb->innerjoin('p.featuress', 'i')
            ->andWhere('i.id = :features_id')
            ->setParameter('features_id', $features_id);
        return $this->qb;
    }

    public function findAllDataJoined($arr_query_data=false, $locale=false)
    {
        $this->selectProductSkuData($locale);

        $this->setJoinProductCategory($locale);

  		if(isset($arr_query_data['q']) && !empty($arr_query_data['q'])){
            $q = $arr_query_data['q'];
            $arr_q = explode(" ", $q);
            $cons = array();

            //leftjoin hashtags
            $this->qb->leftjoin('p.hashtags', 'ht');

            foreach ($arr_q as $key => $query) {
                if (preg_match('#^\##', $query) === 1) {
                    // start with #hashtag
                    $query = str_replace('#', '', $query); // removed #
                    $cons[] = $this->qb->expr()->eq('ht.title', ':query'.$key);
                    $this->qb->setParameter('query'.$key, $query);
                }else{
                    //search by title
                    $cons[] = $this->qb->expr()->like('pt.title', ':query'.$key);
                    $cons[] = $this->qb->expr()->like('ptype.title', ':query'.$key);
                    $cons[] = $this->qb->expr()->like('pstyle.title', ':query'.$key);
                    $cons[] = $this->qb->expr()->like("CONCAT(ptype.title, '-', pstyle.title)", ':query'.$key);
                    $this->qb->setParameter('query'.$key, '%'.$query.'%');
                }
            }

            //search by category title
            //get children product_category_id
            $entityManager = $this->getEntityManager();
            $product_category_root_id = $this->container->getParameter('product_category_root_id');
            $repo_product_category = $entityManager->getRepository(ProductCategory::class);
            $product_categorys = $repo_product_category->findDataByTitle($q, $product_category_root_id)->getQuery()->getResult();
            $product_category_ids = array();
            $data_cat_id = array();
            if($product_categorys){
                foreach ($product_categorys as $product_category) {
                    $product_category_ids[] = $product_category->getId();
                }
                if(!empty($product_category_ids)){
                    foreach ($product_category_ids as $key => $category_id) {
                        $arr_cat_id = array();
                        $pr_category = $repo_product_category->find($category_id);
                        $children = $repo_product_category->children($pr_category, false, null, 'asc', true);
                        foreach ($children as $chi) {
                            $arr_cat_id[] = $chi->getId();
                        }
                        $data_cat_id = array_merge($data_cat_id, $arr_cat_id);
                    }
                    $data_cat_id = array_unique($data_cat_id);
                }
                if(!empty($data_cat_id)){
                    $cons[] = $this->qb->expr()->in('pc.id',':cat_title_id');
                    $this->qb->setParameter('cat_title_id', $data_cat_id);
                }
            }

            $orX = $this->qb->expr()->orX();
            $orX->addMultiple($cons);
            $this->qb->andWhere($orX);

            // foreach ($arr_q as $query) {
            //     $this->qb->andWhere($this->qb->expr()->orX(
            //         $this->qb->expr()->like('pt.title', ':query'),
            //         $this->qb->expr()->like('ptype.title', ':query'),
            //         $this->qb->expr()->like('pstyle.title', ':query'),
            //         $this->qb->expr()->like("CONCAT(ptype.title, '-', pstyle.title)", ':query')
            //     ))
      		// 	->setParameter('query', '%'.$query.'%');
            // }
  		}

        if(isset($arr_query_data['product_category_id']) && !empty($arr_query_data['product_category_id']))
        {
            $this->qb->andWhere($this->qb->expr()->orX(
                $this->qb->expr()->in('pc.id',':pc_id')
            ))
            ->setParameter('pc_id', $arr_query_data['product_category_id']);
        }

        if ((isset($arr_query_data['order_by']) && !empty($arr_query_data['order_by'])) && (isset($arr_query_data['sort']) && !empty($arr_query_data['sort']))){
            if($arr_query_data['order_by'] == 'product_title'){
                $this->qb->resetDQLPart('orderBy');
                $this->setOrderBy($arr_query_data['sort']);
            }
            else if($arr_query_data['order_by'] == 'inventory'){
                $this->qb->resetDQLPart('orderBy');
                $this->qb->addOrderBy('v_inventory_quantity', $arr_query_data['sort']);
            }
            else if($arr_query_data['order_by'] == 'variants'){
                $this->qb->resetDQLPart('orderBy');
                $this->qb->addOrderBy('v_count', $arr_query_data['sort']);
            }
            else if($arr_query_data['order_by'] == 'price'){
                $this->qb->resetDQLPart('orderBy');
                $this->qb->addOrderBy('v_starting_price', $arr_query_data['sort']);
            }
            else if($arr_query_data['order_by'] == 'online-shop'){
                $this->qb->resetDQLPart('orderBy');
                $this->qb->addOrderBy('p.isOnlineShopping', $arr_query_data['sort']);
            }
        }else{
            //default order
            $this->setOrderBy();
        }

  		return $this->qb;
    }

    public function getPublicDataById($product_id=null)
    {
        $this->findAllData();
        $this->setPublic();

        if($product_id){
            $this->qb->andWhere('p.id = :product_id')
                ->setParameter('product_id', $product_id);
        }
        return $this->qb;
    }


    public function findAllActiveData($arr_query_data=false, $locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setPublic($locale);

        if($arr_query_data){

            if( isset($arr_query_data['product_category_id']) && !empty($arr_query_data['product_category_id']) ){
                //$this->qb->leftjoin('p.productCategories', 'pc');
                // ->leftjoin('pc.translations', 'pct');
                $this->qb->andWhere($this->qb->expr()->orX(
                    $this->qb->expr()->in('pc.id',':pc_id')
                ))
                ->setParameter('pc_id', $arr_query_data['product_category_id']);
            }

            if(isset($arr_query_data['searchBox']) && !empty($arr_query_data['searchBox'])){
                $q = $arr_query_data['searchBox'];
                $arr_q = explode(" ", $q);
                $cons = array();

                //leftjoin hashtags
                $this->qb->leftjoin('p.hashtags', 'ht');

                foreach ($arr_q as $key => $query) {
                    if (preg_match('#^\##', $query) === 1) {
                        // start with #hashtag
                        $query = str_replace('#', '', $query); // removed #
                        $cons[] = $this->qb->expr()->eq('ht.title', ':query'.$key);
                        $this->qb->setParameter('query'.$key, $query);
                    }else{
                        //search by title
                        $cons[] = $this->qb->expr()->like('pt.title', ':query'.$key);
                        $cons[] = $this->qb->expr()->like('ptype.title', ':query'.$key);
                        $cons[] = $this->qb->expr()->like('pstyle.title', ':query'.$key);
                        $cons[] = $this->qb->expr()->like("CONCAT(ptype.title, '-', pstyle.title)", ':query'.$key);
                        $this->qb->setParameter('query'.$key, '%'.$query.'%');
                    }
                }

                //search by category title
                //get children product_category_id
                $entityManager = $this->getEntityManager();
                $product_category_root_id = $this->container->getParameter('product_category_root_id');
                $repo_product_category = $entityManager->getRepository(ProductCategory::class);
                $product_categorys = $repo_product_category->findDataByTitle($q, $product_category_root_id)->getQuery()->getResult();
                $product_category_ids = array();
                $data_cat_id = array();
                if($product_categorys){
                    foreach ($product_categorys as $product_category) {
                        $product_category_ids[] = $product_category->getId();
                    }
                    if(!empty($product_category_ids)){
                        foreach ($product_category_ids as $key => $category_id) {
                            $arr_cat_id = array();
                            $pr_category = $repo_product_category->find($category_id);
                            $children = $repo_product_category->children($pr_category, false, null, 'asc', true);
                            foreach ($children as $chi) {
                                $arr_cat_id[] = $chi->getId();
                            }
                            $data_cat_id = array_merge($data_cat_id, $arr_cat_id);
                        }
                        $data_cat_id = array_unique($data_cat_id);
                    }
                    if(!empty($data_cat_id)){
                        $cons[] = $this->qb->expr()->in('pc.id',':cat_title_id');
                        $this->qb->setParameter('cat_title_id', $data_cat_id);
                    }
                }

                $orX = $this->qb->expr()->orX();
                $orX->addMultiple($cons);
                $this->qb->andWhere($orX);
      		}

            /*if(isset($arr_query_data['searchBox']) && !empty($arr_query_data['searchBox']) ){
                $arr_searchBox = ($arr_query_data['searchBox']);
                $this->qb->andWhere($this->qb->expr()->orX(
                            $this->qb->expr()->like('pt.title', ':query'),
                            $this->qb->expr()->like('pt.description',':query')
                        ))
                ->setParameter('query', '%'.$arr_searchBox.'%');
            }*/


            if(isset($arr_query_data['ddlPriceSort']) && !empty($arr_query_data['ddlPriceSort']) ){
                if($arr_query_data['ddlPriceSort']=='TYPE_DESC'){
                    $this->setOrderBy('DESC');
                }else{
                    $this->qb->orderBy('v_starting_price', $arr_query_data['ddlPriceSort']);
                }

            }elseif(isset($arr_query_data['ddlPriceSortMobile']) && !empty($arr_query_data['ddlPriceSortMobile']) ){
                if($arr_query_data['ddlPriceSortMobile']=='TYPE_DESC'){
                    $this->setOrderBy('DESC');
                }else{
                    $this->qb->orderBy('v_starting_price', $arr_query_data['ddlPriceSortMobile']);
                }

            }else{
                $this->setOrderBy();
            }


            if( isset($arr_query_data['shop_by']) && sizeof($arr_query_data['shop_by']) )
            {
                $conditions = array();
                $is_match = false;
                foreach ($arr_query_data['shop_by'] as $shop_by) {
                    if($shop_by=='new'){
                        $conditions[] = $this->qb->expr()->eq('p.isNew', 1);
                        $is_match = true;
                    }elseif($shop_by=='sale'){
                        $conditions[] = $this->qb->expr()->eq('p.isSale', 1);
                        $is_match = true;
                    }elseif($shop_by=='top_saller'){
                        $conditions[] = $this->qb->expr()->eq('p.isTopSeller', 1);
                        $is_match = true;
                    }
                }
                if($is_match){
                    $orX = $this->qb->expr()->orX();
                    $orX->addMultiple($conditions);
                    $this->qb->andWhere($orX);
                }
            }

            if(isset($arr_query_data['startprice']) && isset($arr_query_data['endprice']) )
            {
                // show only online shopping
                // $this->qb->andWhere('p.isOnlineShopping = 1')

                $this->qb
                    ->having('v_starting_price BETWEEN :startPrice AND :endPrice')
                    ->orHaving('p.price BETWEEN :startPrice AND :endPrice')
                    ->setParameter('startPrice', $arr_query_data['startprice'])
                    ->setParameter('endPrice', $arr_query_data['endprice']);

                //v_starting_price for variant price
                //p.price for no-variant price
            }

            if(isset($arr_query_data['hashtag']) && isset($arr_query_data['hashtag']) )
            {
                $this->qb->leftjoin('p.hashtags', 'ht')
                    ->andWhere('ht.id = '.$arr_query_data['hashtag']);
            }

        }else{
            $this->setOrderBy();
        }

        return $this->qb;
    }
    public function findActiveDataByUser($objUser, $locale=false)
    {
        $this->findAllActiveData(array(), $locale);

        $this->qb->leftjoin('p.users', 'u');
        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('u.id', ':user')
        ))
        ->setParameter('user', $objUser);
        return $this->qb;
    }

    public function getActiveDataById($id, $locale=false)
    {
        $this->findAllActiveData(array(), $locale);

        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('p.id', ':id')
        ))
        ->setParameter('id', $id);
        return $this->qb;
    }

    public function getActiveData($id, $locale=false)
    {
        $this->findAllActiveData(array(), $locale);
        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('p.id', ':id')
        ))
        ->setParameter('id', $id);
        return $this->qb;
    }

    public function getActiveDataByProductsGallery($showroom_id,$locale=false)
    {
        $this->findAllActiveData(array(), $locale);
        $this->qb->innerJoin('p.showrooms', 'pgal')
        ->andWhere('pgal.id = :showroom_id')
        ->setParameter('showroom_id', $showroom_id);

        return $this->qb;
    }

    public function getActiveDataByProductsRelated($product, $locale=false)
    {
        $this->findAllActiveData(array(), $locale);

        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->notLike('p.id', ':id')
        ))
        ->setParameter('id', $product->getId());

        if($product->getProductCategories()){
            // $this->qb->leftjoin('p.productCategories', 'pc');
            foreach ($product->getProductCategories() as $key => $value) {
                $cate_id = $value->getId();
                $this->qb->andWhere($this->qb->expr()->andX(
                    $this->qb->expr()->eq('pc.id',':cate_id')
                ))->setParameter('cate_id', $cate_id);
            }
        }

        $this->qb->groupBy('p.id');
        $this->qb->orderBy('RAND()');

        return $this->qb;
    }

    public function getActiveDataCompleteSetByProduct($product, $locale=false)
    {
        $this->findAllActiveData(array(), $locale);

        $style_id = $product->getProductStyleNumber()->getId();
        if($style_id){
            $this->qb->andWhere('pstyle.id = '.$style_id);
        }

        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->notLike('p.id', ':id')
        ))
        ->setParameter('id', $product->getId());
        $this->qb->groupBy('p.id');
        $this->qb->orderBy('RAND()');

        return $this->qb;
    }

    public function getActiveDataProductsByPromotionId($id,$locale=false)
    {
        $locale = ($locale) ? $locale : Locale::getDefault();
        $this->findAllActiveData(array(), $locale);

        // $this->selectProductSkuData($locale);
        // $this->setPublic($locale);

        $this->qb->addSelect('pm')
            ->leftjoin('p.promotions', 'pm');
        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('pm.id', ':pm_id'),
            $this->qb->expr()->eq('pm.status', ':pm_status')
        ))
        ->setParameter('pm_id', $id)
        ->setParameter('pm_status', 1);

        return $this->qb;
    }

    public function getPublishProductsDiscountByDiscountCode($discount_code)
	{
		//QueryBuilder Expr
		$this->qb = $this->createQueryBuilder('p');
		$this->qb->select('p')
			->where('pd.discountCode = :discount_code')
			->setParameter('discount_code', $discount_code)
			->innerJoin('p.discounts', 'pd');
        $this->setPublic();
		return $this->qb;
	}

    public function findPublishProductBestSeller($locale=false)
    {
        $locale = ($locale) ? $locale : Locale::getDefault();
        $this->qb = $this->createQueryBuilder('p');
        $this->qb->select('p, pt');
        $this->qb->addSelect('COUNT(coi) as itemCount')
            ->leftjoin('p.translations', 'pt', "WITH", "pt.locale='$locale'")
            ->leftjoin('p.customerOrderItems', 'coi')
            ->leftjoin('coi.sku', 'sku', "WITH", 'sku.status = 1')
            ->groupBy('p.id')
            ->orderBy('itemCount', 'DESC');

        $this->setSelectPriceData();
        $this->setPublic($locale);

        return $this->qb;
    }

    public function getActiveDataWithPromotion($locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setOrderBy();
        $this->setPublic($locale);
        $this->qb->innerjoin('p.promotions', 'pp');
        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('pp.status', ':promotion_status')
        ))
        ->setParameter('promotion_status', 1);
        return $this->qb;
    }

    public function getActiveDataIsTopSeller($locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setOrderBy();
        $this->setPublic($locale);
        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('p.isTopSeller', ':is_top_seller')
        ))
        ->setParameter('is_top_seller', 1);
        return $this->qb;
    }

    public function getActiveDataIsSale($locale=false)
    {
        $this->selectProductSkuData($locale);
        $this->setOrderBy();
        $this->setPublic($locale);
        $this->qb->andWhere($this->qb->expr()->andX(
            $this->qb->expr()->eq('p.isSale', ':is_sale')
        ))
        ->setParameter('is_sale', 1);
        return $this->qb;
    }

    public function findAllActiveShopOnlineData($arr_query_data=false, $locale=false)
    {
        $this->findAllActiveData($arr_query_data, $locale);
        $this->qb->andWhere('p.isOnlineShopping = 1');
        return $this->qb;
    }
}
