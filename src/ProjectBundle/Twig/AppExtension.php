<?php

namespace ProjectBundle\Twig;
use ProjectBundle\Utils\Collections;
use ProjectBundle\Utils\Products;

use ProjectBundle\Entity\Inspiration;
use ProjectBundle\Entity\InspirationCategory;
use ProjectBundle\Entity\NewsCategory;
use ProjectBundle\Entity\ProductCategory;

class AppExtension extends \Twig_Extension
{
	private $kernel;

	public function __construct($kernel)
    {
        $this->container = $kernel->getContainer();
    }

	public function getFunctions()
	{
		return array(
			new \Twig_SimpleFunction('getCustomerPlan', [$this, 'getCustomerPlan']),
			new \Twig_SimpleFunction('getPriceData', [$this, 'getPriceData']),
			new \Twig_SimpleFunction('getTrackingURL', [$this, 'getTrackingURL']),
			new \Twig_SimpleFunction('getProductTypeAndStyleNumber', [$this, 'getProductTypeAndStyleNumber']),
			new \Twig_SimpleFunction('getInspirationByCategoryId', [$this, 'getInspirationByCategoryId']),
		);
	}

	public function getFilters()
	{
		return array(
			new \Twig_SimpleFilter('slug', array($this, 'slugFilter')),
			new \Twig_SimpleFilter('gender', array($this, 'genderFilter')),
			new \Twig_SimpleFilter('status', array($this, 'statusFilter')),
			new \Twig_SimpleFilter('statusAvailable', array($this, 'statusAvailableFilter')),
			new \Twig_SimpleFilter('couponStatusText', array($this, 'couponStatusText')),
			new \Twig_SimpleFilter('getPercentProductDiscount', array($this, 'getPercentProductDiscount')),
			new \Twig_SimpleFilter('paymentstatus', array($this, 'paymentstatusFilter')),
			new \Twig_SimpleFilter('youtube', array($this, 'youtubeFilter')),
			new \Twig_SimpleFilter('getFileType', array($this, 'getFileType')),
			new \Twig_SimpleFilter('telFilter', array($this, 'telFilter')),
			new \Twig_SimpleFilter('getPathProduct', array($this, 'getPathProductFilter')),
			new \Twig_SimpleFilter('getPathInspiration', array($this, 'getPathInspirationFilter')),
			new \Twig_SimpleFilter('getPathNews', array($this, 'getPathNewsFilter')),
		);
	}

	public function getInspirationByCategoryId($category_id)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$repo = $em->getRepository(Inspiration::class);
		$inspirations = $repo->getToppageActiveDataByCategoryId($category_id)->getQuery()->getResult();
		return $inspirations;
	}

	public function getPathProductFilter($category)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$repo = $em->getRepository(ProductCategory::class);
		$str_path = $this->getStringPath($repo, $category);
		return $str_path;
	}

	public function getPathInspirationFilter($category)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$repo = $em->getRepository(InspirationCategory::class);
		$str_path = $this->getStringPath($repo, $category);
		return $str_path;
	}

	public function getPathNewsFilter($category)
	{
		$em = $this->container->get('doctrine')->getEntityManager();
		$repo = $em->getRepository(NewsCategory::class);
		$str_path = $this->getStringPath($repo, $category);
		return $str_path;
	}

	public function getStringPath($repo, $category)
	{
		$str_path = '';
		$arr_path = array();
		$path = $repo->getPath($category);
		foreach ($path as $key => $p) {
			if($key>0){
				$arr_path[$key] = $p->getTitle();
			}
		}
		$str_path = join(' &#8227; ',$arr_path);
		return $str_path;
		// &#8227;
		// <i class="fa fa-angle-right"></i>
	}

	public function slugFilter($slug)
	{
		// Remove HTML tags
		$slug = preg_replace('/<(.*?)>/u', '', $slug);
		// Remove inner-word punctuation.
		$slug = preg_replace('/[\'"‘’“”]/u', '', $slug);
		// Make it lowercase
		$slug = mb_strtolower($slug, 'UTF-8');
		// remove space
		$slug = preg_replace(array('/\s{2,}/', '/[\t\n]/', '/\s+/'), '-', $slug);
		return $slug;
	}

	public function getCustomerPlan($member)
	{
		return Collections::getCustomerPlan($member);
	}

	public function genderFilter($gender)
	{
		return Collections::wordGender($gender);
	}

	public function statusFilter($status)
	{
		return Collections::wordStatus($status);
	}

	public function statusAvailableFilter($product)
	{
		return Collections::wordStatusAvailable($product);
	}

	public function paymentstatusFilter($status)
	{
		return Collections::wordPaymentStatus($status);
	}

	public function couponStatusText($coupon)
	{
		return Collections::couponStatusText($coupon);
	}

	public function getPriceData($rs)
	{
		return Products::getPriceData($rs);
	}

	public function getPercentProductDiscount($rs)
	{
		return Products::getPercentProductDiscount($rs);
	}

	public function getProductTypeAndStyleNumber($product)
	{
		return Products::getProductTypeAndStyleNumber($product);
	}

	public function getTrackingURL($tracking_url, $tracking_number)
	{
		return Collections::getTrackingURL($tracking_url, $tracking_number);
	}

	public function getName()
	{
		return 'app_extension';
	}

	public function youtubeFilter($url)
    {
      	preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
  		return $matches[1];
    }

	public function getFileType($original_filename)
	{
	    $pieces = explode(".", $original_filename);
	    $fileType = end($pieces);
    	return $fileType;
  	}

	public function telFilter($tel)
	{
		$tel_numbers_only = preg_replace("/[^\d]/", "", $tel);
		return $tel_numbers_only;
	}

}
