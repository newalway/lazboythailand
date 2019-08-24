<?php

namespace ProjectBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ProductCategory
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="product_category")
 * use repository for handy tree functions
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ProductCategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ProductCategory
{
    use ORMBehaviors\Translatable\Translatable,
        ORMBehaviors\Sluggable\Sluggable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumn(name="tree_root", referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="ProductCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="ProductCategory", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * Many ProductCategory have Many Products.
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="productCategories")
     */
    private $products;

    /**
	* @ORM\Column(name="category_code", type="string", length=255, nullable = true)
	*/
	private $categoryCode;

    /**
	* @ORM\Column(name="pattern_image", type="string", length=255, nullable = true)
	*/
	private $patternImage;

    /**
	* @ORM\Column(name="pattern_image_small", type="string", length=255, nullable = true)
	*/
	private $patternImageSmall;

	/**
	* @ORM\Column(name="pattern_image_medium", type="string", length=255, nullable = true)
	*/
	private $patternImageMedium;

	/**
	* @ORM\Column(name="pattern_image_large", type="string", length=255, nullable = true)
	*/
	private $patternImageLarge;

    /**
	* @ORM\Column(name="is_only_gallery", type="boolean", options={"default":0})
	*/
	private $isOnlyGallery = false;

    /**
	* @ORM\OneToMany(targetEntity="VariantOption", mappedBy="productCategory")
	*/
	private $variantOptions;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $banner_image;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $banner_image_mobile;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function getSluggableFields()
    {
        return ['titleSlug'];
    }

    //method for getSluggableFields
    public function getTitleSlug()
    {
        // get english title for slug generation
        return $this->translate('en')->getTitle();
        // get the title translation in current locale
        // return $this->translate(null,true)->getTitle();
    }

    // don't need override this function
    // public function generateSlugValue($values)
    // {
    //     $text = str_replace(' ', '-', $values);
    //     $text = implode('-', $text);
    //     $text = strtolower($text);
    //     return $text;
    // }
    // override
    // public function generateSlug()
    // {
    //     $localTranslation = $this->getLocale();
    //     $categorySlug = $this->getTranslatable()->getCategory()->translate($localTranslation)->getSlug();
    //     $this->slug = $categorySlug.'/'.$urlized;
    // }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function setParent(ProductCategory $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }


    /**
     * Get the value of Lft
     *
     * @return mixed
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set the value of Lft
     *
     * @param mixed lft
     *
     * @return self
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get the value of Lvl
     *
     * @return mixed
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set the value of Lvl
     *
     * @param mixed lvl
     *
     * @return self
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get the value of Rgt
     *
     * @return mixed
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set the value of Rgt
     *
     * @param mixed rgt
     *
     * @return self
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Set the value of Root
     *
     * @param mixed root
     *
     * @return self
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get the value of Children
     *
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set the value of Children
     *
     * @param mixed children
     *
     * @return self
     */
    public function setChildren($children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Get the value of Products
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set the value of Products
     *
     * @param mixed products
     *
     * @return self
     */
    public function setProducts($products)
    {
        $this->products = $products;

        return $this;
    }

    /**
     * @param mixed products
     */
    public function removeProducts(Product $product)
    {
        if (false === $this->products->contains($product)) {
            return;
        }
        $this->products->removeElement($product);
        $product->removeProductCategories($this);
    }

    /**
     * @param mixed products
     */
    public function addProducts(Product $product)
    {
        if (true === $this->products->contains($product)) {
            return;
        }
        $this->products->add($product);
        $product->addProductCategories($this);
    }

    /**
     * Set the value of Id
     *
     * @param int id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Category Code
     *
     * @return mixed
     */
    public function getCategoryCode()
    {
        return $this->categoryCode;
    }

    /**
     * Set the value of Category Code
     *
     * @param mixed categoryCode
     *
     * @return self
     */
    public function setCategoryCode($categoryCode)
    {
        $this->categoryCode = $categoryCode;

        return $this;
    }

    public function removePatternImage()
	{
		$this->setPatternImage(null);
		$this->setPatternImageSmall(null);
		$this->setPatternImageMedium(null);
		$this->setPatternImageLarge(null);
	}

    /**
     * Get the value of Pattern Image
     *
     * @return mixed
     */
    public function getPatternImage()
    {
        return $this->patternImage;
    }

    /**
     * Set the value of Pattern Image
     *
     * @param mixed patternImage
     *
     * @return self
     */
    public function setPatternImage($patternImage)
    {
        $this->patternImage = $patternImage;

        return $this;
    }

    /**
     * Get the value of Pattern Image Small
     *
     * @return mixed
     */
    public function getPatternImageSmall()
    {
        return $this->patternImageSmall;
    }

    /**
     * Set the value of Pattern Image Small
     *
     * @param mixed patternImageSmall
     *
     * @return self
     */
    public function setPatternImageSmall($patternImageSmall)
    {
        $this->patternImageSmall = $patternImageSmall;

        return $this;
    }

    /**
     * Get the value of Pattern Image Medium
     *
     * @return mixed
     */
    public function getPatternImageMedium()
    {
        return $this->patternImageMedium;
    }

    /**
     * Set the value of Pattern Image Medium
     *
     * @param mixed patternImageMedium
     *
     * @return self
     */
    public function setPatternImageMedium($patternImageMedium)
    {
        $this->patternImageMedium = $patternImageMedium;

        return $this;
    }

    /**
     * Get the value of Pattern Image Large
     *
     * @return mixed
     */
    public function getPatternImageLarge()
    {
        return $this->patternImageLarge;
    }

    /**
     * Set the value of Pattern Image Large
     *
     * @param mixed patternImageLarge
     *
     * @return self
     */
    public function setPatternImageLarge($patternImageLarge)
    {
        $this->patternImageLarge = $patternImageLarge;

        return $this;
    }


    /**
     * Get the value of Is Only Gallery
     *
     * @return mixed
     */
    public function getIsOnlyGallery()
    {
        return $this->isOnlyGallery;
    }

    /**
     * Set the value of Is Only Gallery
     *
     * @param mixed isOnlyGallery
     *
     * @return self
     */
    public function setIsOnlyGallery($isOnlyGallery)
    {
        $this->isOnlyGallery = $isOnlyGallery;

        return $this;
    }


    /**
     * Get the value of Variant Options
     *
     * @return mixed
     */
    public function getVariantOptions()
    {
        return $this->variantOptions;
    }

    /**
     * Set the value of Variant Options
     *
     * @param mixed variantOptions
     *
     * @return self
     */
    public function setVariantOptions($variantOptions)
    {
        $this->variantOptions = $variantOptions;

        return $this;
    }


    /**
     * Get the value of Image
     *
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of Image
     *
     * @param mixed image
     *
     * @return self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function removeImage()
	{
		$this->setImage(null);
	}

    /**
     * Get the value of Banner Image
     *
     * @return mixed
     */
    public function getBannerImage()
    {
        return $this->banner_image;
    }

    /**
     * Set the value of Banner Image
     *
     * @param mixed banner_image
     *
     * @return self
     */
    public function setBannerImage($banner_image)
    {
        $this->banner_image = $banner_image;

        return $this;
    }

    public function removeBannerImage()
	{
		$this->setBannerImage(null);
	}


    /**
     * Get the value of Banner Image Mobile
     *
     * @return mixed
     */
    public function getBannerImageMobile()
    {
        return $this->banner_image_mobile;
    }

    /**
     * Set the value of Banner Image Mobile
     *
     * @param mixed banner_image_mobile
     *
     * @return self
     */
    public function setBannerImageMobile($banner_image_mobile)
    {
        $this->banner_image_mobile = $banner_image_mobile;

        return $this;
    }
 
}
