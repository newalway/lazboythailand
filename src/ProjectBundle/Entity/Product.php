<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Product
{
	use ORMBehaviors\Translatable\Translatable,
		ORMBehaviors\Sluggable\Sluggable;

	/**
	* @ORM\Column(type="integer")
	* @ORM\Id
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
	private $id;

	/**
	* @ORM\Column(type="string", length=255, nullable = true)
	*/
	private $sku;

	/**
	* @ORM\Column(type="decimal", scale=2, nullable = true, options={"default":0})
	*/
	private $price;

	/**
	* @ORM\Column(type="string", length=255, nullable = true)
	*/
	private $image;

	/**
	* @ORM\Column(type="string", length=255, nullable = true)
	*/
	private $imageDimension;

	/** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
	private $updatedAt;

	/** @ORM\Column(name="created_at", type="datetime") */
	private $createdAt;

	/**
	* @ORM\Column(type="smallint", options={"unsigned":true, "default":1})
	*/
	private $status = 1;

	/** @ORM\Column(name="publish_date", type="datetime") */
	private $publishDate;

	/**
	* @ORM\Column(type="integer", options={"unsigned":true, "default":0})
	*/
	private $position = 0;

	/**
	* @ORM\Column(name="compare_at_price", type="decimal", scale=2, nullable = true, options={"default":0})
	*/
	private $compareAtPrice;

	/**
	* @ORM\Column(name="inventory_policy_status", type="smallint", options={"default":0})
	*/
	private $inventoryPolicyStatus = 0;

	/**
	* @ORM\Column(name="inventory_quantity", type="integer", nullable = true)
	*/
	private $inventoryQuantity;

	/**
	* @ORM\Column(type="decimal", scale=2, nullable = true, options={"default":0})
	*/
	private $grams;

	/**
	* @ORM\Column(type="decimal", scale=2, nullable = true, options={"default":0})
	*/
	private $weight;

	/**
	* @ORM\Column(name="weight_unit", type="string", length=45, nullable = true)
	*/
	private $weightUnit;

	/**
	* Many Products have Many Category.
	* @ORM\ManyToMany(targetEntity="ProductCategory", inversedBy="products")
	* @ORM\JoinTable(name="products_categories")
	*/
	private $productCategories;

	/**
	* Many Products have Many Hashtags.
	* @ORM\ManyToMany(targetEntity="Hashtag", inversedBy="products")
	* @ORM\JoinTable(name="products_hashtags")
	*/
	private $hashtags;

	/**
	* Many Products have Many Showrooms.
	* @ORM\ManyToMany(targetEntity="Showroom", inversedBy="products")
	* @ORM\JoinTable(name="products_showrooms")
	*/
	private $showrooms;

	/**
	* Many Products have Many Discounts.
	* @ORM\ManyToMany(targetEntity="Discount", inversedBy="products")
	* @ORM\JoinTable(name="products_discounts")
	*/
	private $discounts;

	/**
	* Many Products have Many Promotions.
	* @ORM\ManyToMany(targetEntity="Promotion", inversedBy="products")
	* @ORM\JoinTable(name="products_promotions")
	*/
	private $promotions;

	/**
	* Many Products have Many ProductOptions.
	* @ORM\ManyToMany(targetEntity="ProductOption", inversedBy="products")
	* @ORM\JoinTable(name="products_options")
	*/
	private $productOptions;

	/**
	* @ORM\OneToMany(targetEntity="Sku", mappedBy="product")
	*/
	private $skus;

	/**
	* @ORM\OneToMany(targetEntity="Variant", mappedBy="product")
	*/
	private $variants;

	/**
	* @ORM\OneToMany(targetEntity="ProductImage", mappedBy="product")
	*/
	private $productImages;

	/**
     * Many Products have Many Inspiration.
     * @ORM\ManyToMany(targetEntity="Inspiration", mappedBy="products")
     */
    private $inspirations;

	/**
     * Many Products have Many Features.
     * @ORM\ManyToMany(targetEntity="Features", mappedBy="products")
     */
    private $featuress;

	/**
	* @ORM\Column(name="image_small", type="string", length=255, nullable = true)
	*/
	private $imageSmall;

	/**
	* @ORM\Column(name="image_medium", type="string", length=255, nullable = true)
	*/
	private $imageMedium;

	/**
	* @ORM\Column(name="image_large", type="string", length=255, nullable = true)
	*/
	private $imageLarge;

	/**
	* @ORM\OneToMany(targetEntity="CustomerOrderItem", mappedBy="product")
	*/
	private $customerOrderItems;

	/**
	* @ORM\Column(name="is_new", type="boolean", options={"default":0})
	*/
	private $isNew = false;

	/**
	* @ORM\Column(name="is_sale", type="boolean", options={"default":0})
	*/
	private $isSale = false;

	/**
	* @ORM\Column(name="is_top_seller", type="boolean", options={"default":0})
	*/
	private $isTopSeller = false;

	/**
	* @ORM\Column(name="variant_type", type="string", length=45, nullable = true)
	*/
	private $variantType;


	/**
	* @ORM\Column(name="review_count", type="integer", nullable = true, options={"default":0})
	*/
	private $reviewCount;

	/**
	* @ORM\Column(name="rating_count", type="integer", nullable = true, options={"default":0})
	*/
	private $ratingCount;

	/**
	* @ORM\Column(name="rating_sum", type="integer", nullable = true, options={"default":0})
	*/
	private $ratingSum;

	/**
	* @ORM\Column(name="rating_average",type="decimal", scale=2, nullable = true, options={"default":0})
	*/
	private $ratingAverage;


	/**
	* @ORM\OneToMany(targetEntity="Review", mappedBy="product")
	*/
	private $review;

	/**
	* @ORM\Column(name="dim_body_depth", type="decimal", scale=2, nullable=true)
	*/
	private $dimBodyDepth;

	/**
	* @ORM\Column(name="dim_body_height", type="decimal", scale=2, nullable=true)
	*/
	private $dimBodyHeight;

	/**
	* @ORM\Column(name="dim_body_width", type="decimal", scale=2, nullable=true)
	*/
	private $dimBodyWidth;

	/**
	* @ORM\Column(name="dim_seat_depth", type="decimal", scale=2, nullable=true)
	*/
	private $dimSeatDepth;

	/**
	* @ORM\Column(name="dim_seat_height", type="decimal", scale=2, nullable=true)
	*/
	private $dimSeatHeight;

	/**
	* @ORM\Column(name="dim_seat_width", type="decimal", scale=2, nullable=true)
	*/
	private $dimSeatWidth;

	/**
	* @ORM\Column(name="dim_full_extension", type="decimal", scale=2, nullable=true)
	*/
	private $dimFullExtension;

	/**
     * Many Products have Many Users.
     * @ORM\ManyToMany(targetEntity="User", mappedBy="products")
     */
    private $users;

	/**
	* @ORM\Column(name="is_online_shopping", type="boolean", options={"default":0})
	*/
	private $isOnlineShopping = false;

	/**
	* @ORM\Column(name="is_imported", type="boolean", options={"default":0})
	*/
	private $isImported = false;

	/**
     * @ORM\ManyToOne(targetEntity="ProductType", inversedBy="products")
     * @ORM\JoinColumn(name="product_type_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $productType;

	/**
	 * @ORM\ManyToOne(targetEntity="ProductStyleNumber", inversedBy="products")
	 * @ORM\JoinColumn(name="product_style_number_id", referencedColumnName="id", onDelete="RESTRICT")
	 */
	private $productStyleNumber;

	public function __call($method, $arguments)
	{
		return $this->proxyCurrentLocaleTranslation($method, $arguments);
	}

	public function __construct()
	{
		$this->showrooms = new ArrayCollection();
		$this->hashtags = new ArrayCollection();
		$this->skus = new ArrayCollection();
		$this->variants = new ArrayCollection();
		$this->productImages = new ArrayCollection();
		$this->discounts = new ArrayCollection();
		$this->promotions = new ArrayCollection();
		$this->customerOrderItems = new ArrayCollection();
		$this->productCategories = new ArrayCollection();
		$this->inspirations = new ArrayCollection();
		$this->featuress = new ArrayCollection();
		$this->productOptions = new ArrayCollection();
		$this->users = new ArrayCollection();
	}

	/**
	*
	* @ORM\PrePersist
	* @ORM\PreUpdate
	*/
	public function updatedTimestamps()
	{
		$this->setUpdatedAt(new \DateTime('now'));
		if ($this->getCreatedAt() == null) {
			$this->setCreatedAt(new \DateTime('now'));
		}
	}

	public function getSluggableFields()
    {
        return ['slugTitle'];
    }

    //method for getSluggableFields
    public function getSlugTitle()
    {
        // get english title for slug generation
        return $this->translate('en')->getTitle();
        // get the title translation in current locale
        // return $this->translate(null,true)->getTitle();
    }

	/**
	* Get the value of Id
	*
	* @return mixed
	*/
	public function getId()
	{
		return $this->id;
	}

	/**
	* Set the value of Id
	*
	* @param mixed id
	*
	* @return self
	*/
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	* Get the value of Price
	*
	* @return mixed
	*/
	public function getPrice()
	{
		return $this->price;
	}

	/**
	* Set the value of Price
	*
	* @param mixed price
	*
	* @return self
	*/
	public function setPrice($price)
	{
		$this->price = $price;

		return $this;
	}

	/**
	* Set the value of Created At
	*
	* @param mixed createdAt
	*
	* @return self
	*/
	public function setCreatedAt($createdAt)
	{
		$this->createdAt = $createdAt;

		return $this;
	}

	/**
	* Get the value of Created At
	*
	* @return mixed
	*/
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	/**
	* Get the value of Updated At
	*
	* @return mixed
	*/
	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}

	/**
	* Set the value of Updated At
	*
	* @param mixed updatedAt
	*
	* @return self
	*/
	public function setUpdatedAt($updatedAt)
	{
		$this->updatedAt = $updatedAt;

		return $this;
	}


	/**
	* Get the value of Status
	*
	* @return mixed
	*/
	public function getStatus()
	{
		return $this->status;
	}

	/**
	* Set the value of Status
	*
	* @param mixed status
	*
	* @return self
	*/
	public function setStatus($status)
	{
		$this->status = $status;

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
		$this->setImageSmall(null);
		$this->setImageMedium(null);
		$this->setImageLarge(null);
	}

	/**
	* Get the value of Position
	*
	* @return mixed
	*/
	public function getPosition()
	{
		return $this->position;
	}

	/**
	* Set the value of Position
	*
	* @param mixed position
	*
	* @return self
	*/
	public function setPosition($position)
	{
		$this->position = $position;

		return $this;
	}

	/**
	* Get the value of Sku
	*
	* @return mixed
	*/
	public function getSku()
	{
		return $this->sku;
	}

	/**
	* Set the value of Sku
	*
	* @param mixed sku
	*
	* @return self
	*/
	public function setSku($sku)
	{
		$this->sku = $sku;

		return $this;
	}

	/**
	* Get the value of Variants
	*
	* @return mixed
	*/
	public function getVariants()
	{
		return $this->variants;
	}

	/**
	* Set the value of Variants
	*
	* @param mixed variants
	*
	* @return self
	*/
	public function setVariants($variants)
	{
		$this->variants = $variants;

		return $this;
	}

	/**
	* Get the value of Many Products have Many Hashtags.
	*
	* @return mixed
	*/
	public function getHashtags()
	{
		return $this->hashtags;
	}

	/**
	* Set the value of Many Products have Many Hashtags.
	*
	* @param mixed hashtags
	*
	* @return self
	*/
	public function setHashtags($hashtags)
	{
		$this->hashtags = $hashtags;

		return $this;
	}

	/**
	* @param mixed hashtags
	*/
	public function removeHashtags(Hashtag $hashtag)
	{
		if (false === $this->hashtags->contains($hashtag)) {
			return;
		}
		$this->hashtags->removeElement($hashtag);
		$hashtag->removeProducts($this);
	}

	/**
	* @param mixed hashtags
	*/
	public function addHashtags(Hashtag $hashtag)
	{
		if (true === $this->hashtags->contains($hashtag)) {
			return;
		}
		$this->hashtags->add($hashtag);
		$hashtag->addProducts($this);
	}

	/**
	* Get the value of Skus
	*
	* @return mixed
	*/
	public function getSkus()
	{
		return $this->skus;
	}

	/**
	* Set the value of Skus
	*
	* @param mixed skus
	*
	* @return self
	*/
	public function setSkus($skus)
	{
		$this->skus = $skus;

		return $this;
	}


	/**
	* Get the value of Compare At Price
	*
	* @return mixed
	*/
	public function getCompareAtPrice()
	{
		return $this->compareAtPrice;
	}

	/**
	* Set the value of Compare At Price
	*
	* @param mixed compareAtPrice
	*
	* @return self
	*/
	public function setCompareAtPrice($compareAtPrice)
	{
		$this->compareAtPrice = $compareAtPrice;

		return $this;
	}

	/**
	* Get the value of Inventory Policy Status
	*
	* @return mixed
	*/
	public function getInventoryPolicyStatus()
	{
		return $this->inventoryPolicyStatus;
	}

	/**
	* Set the value of Inventory Policy Status
	*
	* @param mixed inventoryPolicyStatus
	*
	* @return self
	*/
	public function setInventoryPolicyStatus($inventoryPolicyStatus)
	{
		$this->inventoryPolicyStatus = $inventoryPolicyStatus;

		return $this;
	}

	/**
	* Get the value of Inventory Quantity
	*
	* @return mixed
	*/
	public function getInventoryQuantity()
	{
		return $this->inventoryQuantity;
	}

	/**
	* Set the value of Inventory Quantity
	*
	* @param mixed inventoryQuantity
	*
	* @return self
	*/
	public function setInventoryQuantity($inventoryQuantity)
	{
		$this->inventoryQuantity = $inventoryQuantity;

		return $this;
	}

	/**
	* Get the value of Grams
	*
	* @return mixed
	*/
	public function getGrams()
	{
		return $this->grams;
	}

	/**
	* Set the value of Grams
	*
	* @param mixed grams
	*
	* @return self
	*/
	public function setGrams($grams)
	{
		$this->grams = $grams;

		return $this;
	}

	/**
	* Get the value of Weight
	*
	* @return mixed
	*/
	public function getWeight()
	{
		return $this->weight;
	}

	/**
	* Set the value of Weight
	*
	* @param mixed weight
	*
	* @return self
	*/
	public function setWeight($weight)
	{
		$this->weight = $weight;

		return $this;
	}

	/**
	* Get the value of Weight Unit
	*
	* @return mixed
	*/
	public function getWeightUnit()
	{
		return $this->weightUnit;
	}

	/**
	* Set the value of Weight Unit
	*
	* @param mixed weightUnit
	*
	* @return self
	*/
	public function setWeightUnit($weightUnit)
	{
		$this->weightUnit = $weightUnit;

		return $this;
	}

	/**
	* Get the value of Image Small
	*
	* @return mixed
	*/
	public function getImageSmall()
	{
		return $this->imageSmall;
	}

	/**
	* Set the value of Image Small
	*
	* @param mixed imageSmall
	*
	* @return self
	*/
	public function setImageSmall($imageSmall)
	{
		$this->imageSmall = $imageSmall;

		return $this;
	}

	/**
	* Get the value of Image Medium
	*
	* @return mixed
	*/
	public function getImageMedium()
	{
		return $this->imageMedium;
	}

	/**
	* Set the value of Image Medium
	*
	* @param mixed imageMedium
	*
	* @return self
	*/
	public function setImageMedium($imageMedium)
	{
		$this->imageMedium = $imageMedium;

		return $this;
	}

	/**
	* Get the value of Image Large
	*
	* @return mixed
	*/
	public function getImageLarge()
	{
		return $this->imageLarge;
	}

	/**
	* Set the value of Image Large
	*
	* @param mixed imageLarge
	*
	* @return self
	*/
	public function setImageLarge($imageLarge)
	{
		$this->imageLarge = $imageLarge;

		return $this;
	}


	/**
	* Get the value of Product Images
	*
	* @return mixed
	*/
	public function getProductImages()
	{
		return $this->productImages;
	}

	/**
	* Set the value of Product Images
	*
	* @param mixed productImages
	*
	* @return self
	*/
	public function setProductImages($productImages)
	{
		$this->productImages = $productImages;

		return $this;
	}


	/**
	* Get the value of Many Products have Many Showrooms.
	*
	* @return mixed
	*/
	public function getShowrooms()
	{
		return $this->showrooms;
	}

	/**
	* Set the value of Many Products have Many Showrooms.
	*
	* @param mixed showrooms
	*
	* @return self
	*/
	public function setShowrooms($showrooms)
	{
		$this->showrooms = $showrooms;

		return $this;
	}

	/**
	* @param mixed showrooms
	*/
	public function removeShowrooms(Showroom $showroom)
	{
		if (false === $this->showrooms->contains($showroom)) {
			return;
		}
		$this->showrooms->removeElement($showroom);
		$showroom->removeProducts($this);
	}

	/**
	* @param mixed showrooms
	*/
	public function addShowrooms(Showroom $showroom)
	{
		if (true === $this->showrooms->contains($showroom)) {
			return;
		}
		$this->showrooms->add($showroom);
		$showroom->addProducts($this);
	}

	/**
	* Get the value of Publish Date
	*
	* @return mixed
	*/
	public function getPublishDate()
	{
		return $this->publishDate;
	}

	/**
	* Set the value of Publish Date
	*
	* @param mixed publishDate
	*
	* @return self
	*/
	public function setPublishDate($publishDate)
	{
		$this->publishDate = $publishDate;

		return $this;
	}

	/**
	* Get the value of Many Products have Many Discounts.
	*
	* @return mixed
	*/
	public function getDiscounts()
	{
		return $this->discounts;
	}

	/**
	* Set the value of Many Products have Many Discounts.
	*
	* @param mixed discounts
	*
	* @return self
	*/
	public function setDiscounts($discounts)
	{
		$this->discounts = $discounts;

		return $this;
	}

	/**
	* @param mixed discounts
	*/
	public function removeDiscounts(Discount $discount)
	{
		if (false === $this->discounts->contains($discount)) {
			return;
		}
		$this->discounts->removeElement($discount);
		$discount->removeProducts($this);
	}

	/**
	* @param mixed discounts
	*/
	public function addDiscounts(Discount $discount)
	{
		if (true === $this->discounts->contains($discount)) {
			return;
		}
		$this->discounts->add($discount);
		$discount->addProducts($this);
	}


	/**
	* Get the value of Many Products have Many Promotions.
	*
	* @return mixed
	*/
	public function getPromotions()
	{
		return $this->promotions;
	}

	/**
	* Set the value of Many Products have Many Promotions.
	*
	* @param mixed promotions
	*
	* @return self
	*/
	public function setPromotions($promotions)
	{
		$this->promotions = $promotions;

		return $this;
	}

	/**
	* @param mixed promotions
	*/
	public function removePromotions(Promotion $promotion)
	{
		if (false === $this->promotions->contains($promotion)) {
			return;
		}
		$this->promotions->removeElement($promotion);
		$promotion->removeProducts($this);
	}

	/**
	* @param mixed promotions
	*/
	public function addPromotions(Promotion $promotion)
	{
		if (true === $this->promotions->contains($promotion)) {
			return;
		}
		$this->promotions->add($promotion);
		$promotion->addProducts($this);
	}


	/**
	* Get the value of Customer Order Items
	*
	* @return mixed
	*/
	public function getCustomerOrderItems()
	{
		return $this->customerOrderItems;
	}

	/**
	* Set the value of Customer Order Items
	*
	* @param mixed customerOrderItems
	*
	* @return self
	*/
	public function setCustomerOrderItems($customerOrderItems)
	{
		$this->customerOrderItems = $customerOrderItems;

		return $this;
	}

	/**
	* Get the value of Is New
	*
	* @return mixed
	*/
	public function getIsNew()
	{
		return $this->isNew;
	}

	/**
	* Set the value of Is New
	*
	* @param mixed isNew
	*
	* @return self
	*/
	public function setIsNew($isNew)
	{
		$this->isNew = $isNew;

		return $this;
	}

    /**
     * Get the value of Many Products have Many Category.
     *
     * @return mixed
     */
    public function getProductCategories()
    {
        return $this->productCategories;
    }

    /**
     * Set the value of Many Products have Many Category.
     *
     * @param mixed productCategories
     *
     * @return self
     */
    public function setProductCategories($productCategories)
    {
        $this->productCategories = $productCategories;

        return $this;
    }

	/**
	* @param mixed productCategories
	*/
	public function removeProductCategories(ProductCategory $productCategory)
	{
		if (false === $this->productCategories->contains($productCategory)) {
			return;
		}
		$this->productCategories->removeElement($productCategory);
		$productCategory->removeProducts($this);
	}

	/**
	* @param mixed productCategories
	*/
	public function addProductCategories(ProductCategory $productCategory)
	{
		if (true === $this->productCategories->contains($productCategory)) {
			return;
		}
		$this->productCategories->add($productCategory);
		$productCategory->addProducts($this);
	}

    /**
     * Get the value of Many Products have Many ProductOptions.
     *
     * @return mixed
     */
    public function getProductOptions()
    {
        return $this->productOptions;
    }

    /**
     * Set the value of Many Products have Many ProductOptions.
     *
     * @param mixed productOptions
     *
     * @return self
     */
    public function setProductOptions($productOptions)
    {
        $this->productOptions = $productOptions;

        return $this;
    }

	/**
	* @param mixed productOptions
	*/
	public function removeProductOptions(ProductOption $productOption)
	{
		if (false === $this->productOptions->contains($productOption)) {
			return;
		}
		$this->productOptions->removeElement($productOption);
		$productOption->removeProducts($this);
	}

	/**
	* @param mixed productOptions
	*/
	public function addProductOptions(ProductOption $productOption)
	{
		if (true === $this->productOptions->contains($productOption)) {
			return;
		}
		$this->productOptions->add($productOption);
		$productOption->addProducts($this);
	}


    /**
     * Get the value of Many Products have Many Inspiration.
     *
     * @return mixed
     */
    public function getInspirations()
    {
        return $this->inspirations;
    }

    /**
     * Set the value of Many Products have Many Inspiration.
     *
     * @param mixed inspirations
     *
     * @return self
     */
    public function setInspirations($inspirations)
    {
        $this->inspirations = $inspirations;

        return $this;
    }

	/**
     * @param mixed inspirations
     */
    public function removeInspirations(Inspiration $inspiration)
    {
        if (false === $this->inspirations->contains($inspiration)) {
            return;
        }
        $this->inspirations->removeElement($inspiration);
        $inspiration->removeProducts($this);
    }

    /**
     * @param mixed inspirations
     */
    public function addInspirations(Inspiration $inspiration)
    {
        if (true === $this->inspirations->contains($inspiration)) {
            return;
        }
        $this->inspirations->add($inspiration);
        $inspiration->addProducts($this);
    }

    /**
     * Get the value of Many Products have Many Features.
     *
     * @return mixed
     */
    public function getFeaturess()
    {
        return $this->featuress;
    }

    /**
     * Set the value of Many Products have Many Features.
     *
     * @param mixed featuress
     *
     * @return self
     */
    public function setFeaturess($featuress)
    {
        $this->featuress = $featuress;

        return $this;
    }

	/**
     * @param mixed featuress
     */
    public function removeFeaturess(Features $features)
    {
        if (false === $this->featuress->contains($features)) {
            return;
        }
        $this->featuress->removeElement($features);
        $features->removeProducts($this);
    }

    /**
     * @param mixed featuress
     */
    public function addFeaturess(Features $features)
    {
        if (true === $this->featuress->contains($features)) {
            return;
        }
        $this->featuress->add($features);
        $features->addProducts($this);
    }

    /**
     * Get the value of Variant Type
     *
     * @return mixed
     */
    public function getVariantType()
    {
        return $this->variantType;
    }

    /**
     * Set the value of Variant Type
     *
     * @param mixed variantType
     *
     * @return self
     */
    public function setVariantType($variantType)
    {
        $this->variantType = $variantType;

        return $this;
    }

    /**
     * Get the value of Is Sale
     *
     * @return mixed
     */
    public function getIsSale()
    {
        return $this->isSale;
    }

    /**
     * Set the value of Is Sale
     *
     * @param mixed isSale
     *
     * @return self
     */
    public function setIsSale($isSale)
    {
        $this->isSale = $isSale;

        return $this;
    }

    /**
     * Get the value of Is Top Seller
     *
     * @return mixed
     */
    public function getIsTopSeller()
    {
        return $this->isTopSeller;
    }

    /**
     * Set the value of Is Top Seller
     *
     * @param mixed isTopSeller
     *
     * @return self
     */
    public function setIsTopSeller($isTopSeller)
    {
        $this->isTopSeller = $isTopSeller;

        return $this;
    }


    /**
     * Get the value of Review
     *
     * @return mixed
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set the value of Review
     *
     * @param mixed review
     *
     * @return self
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get the value of Dim Body Depth
     *
     * @return mixed
     */
    public function getDimBodyDepth()
    {
        return $this->dimBodyDepth;
    }

    /**
     * Set the value of Dim Body Depth
     *
     * @param mixed dimBodyDepth
     *
     * @return self
     */
    public function setDimBodyDepth($dimBodyDepth)
    {
        $this->dimBodyDepth = $dimBodyDepth;

        return $this;
    }

    /**
     * Get the value of Dim Body Height
     *
     * @return mixed
     */
    public function getDimBodyHeight()
    {
        return $this->dimBodyHeight;
    }

    /**
     * Set the value of Dim Body Height
     *
     * @param mixed dimBodyHeight
     *
     * @return self
     */
    public function setDimBodyHeight($dimBodyHeight)
    {
        $this->dimBodyHeight = $dimBodyHeight;

        return $this;
    }

    /**
     * Get the value of Dim Body Width
     *
     * @return mixed
     */
    public function getDimBodyWidth()
    {
        return $this->dimBodyWidth;
    }

    /**
     * Set the value of Dim Body Width
     *
     * @param mixed dimBodyWidth
     *
     * @return self
     */
    public function setDimBodyWidth($dimBodyWidth)
    {
        $this->dimBodyWidth = $dimBodyWidth;

        return $this;
    }

    /**
     * Get the value of Dim Seat Depth
     *
     * @return mixed
     */
    public function getDimSeatDepth()
    {
        return $this->dimSeatDepth;
    }

    /**
     * Set the value of Dim Seat Depth
     *
     * @param mixed dimSeatDepth
     *
     * @return self
     */
    public function setDimSeatDepth($dimSeatDepth)
    {
        $this->dimSeatDepth = $dimSeatDepth;

        return $this;
    }

    /**
     * Get the value of Dim Seat Height
     *
     * @return mixed
     */
    public function getDimSeatHeight()
    {
        return $this->dimSeatHeight;
    }

    /**
     * Set the value of Dim Seat Height
     *
     * @param mixed dimSeatHeight
     *
     * @return self
     */
    public function setDimSeatHeight($dimSeatHeight)
    {
        $this->dimSeatHeight = $dimSeatHeight;

        return $this;
    }

    /**
     * Get the value of Dim Seat Width
     *
     * @return mixed
     */
    public function getDimSeatWidth()
    {
        return $this->dimSeatWidth;
    }

    /**
     * Set the value of Dim Seat Width
     *
     * @param mixed dimSeatWidth
     *
     * @return self
     */
    public function setDimSeatWidth($dimSeatWidth)
    {
        $this->dimSeatWidth = $dimSeatWidth;

        return $this;
    }


    /**
     * Get the value of Many Products have Many Users.
     *
     * @return mixed
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Set the value of Many Products have Many Users.
     *
     * @param mixed users
     *
     * @return self
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

	/**
	* @param mixed usres
	*/
	public function removeUsers(User $user)
	{
		if (false === $this->users->contains($user)) {
			return;
		}
		$this->users->removeElement($user);
		$user->removeProducts($this);
	}

	/**
	* @param mixed usres
	*/
	public function addUsers(User $user)
	{
		if (true === $this->users->contains($user)) {
			return;
		}
		$this->users->add($user);
		$user->addProducts($this);
	}


    /**
     * Get the value of Review Count
     *
     * @return mixed
     */
    public function getReviewCount()
    {
        return $this->reviewCount;
    }

    /**
     * Set the value of Review Count
     *
     * @param mixed reviewCount
     *
     * @return self
     */
    public function setReviewCount($reviewCount)
    {
        $this->reviewCount = $reviewCount;

        return $this;
    }

    /**
     * Get the value of Rating Count
     *
     * @return mixed
     */
    public function getRatingCount()
    {
        return $this->ratingCount;
    }

    /**
     * Set the value of Rating Count
     *
     * @param mixed ratingCount
     *
     * @return self
     */
    public function setRatingCount($ratingCount)
    {
        $this->ratingCount = $ratingCount;

        return $this;
    }

    /**
     * Get the value of Rating Sum
     *
     * @return mixed
     */
    public function getRatingSum()
    {
        return $this->ratingSum;
    }

    /**
     * Set the value of Rating Sum
     *
     * @param mixed ratingSum
     *
     * @return self
     */
    public function setRatingSum($ratingSum)
    {
        $this->ratingSum = $ratingSum;

        return $this;
    }

    /**
     * Get the value of Rating Average
     *
     * @return mixed
     */
    public function getRatingAverage()
    {
        return $this->ratingAverage;
    }

    /**
     * Set the value of Rating Average
     *
     * @param mixed ratingAverage
     *
     * @return self
     */
    public function setRatingAverage($ratingAverage)
    {
        $this->ratingAverage = $ratingAverage;

        return $this;
    }

    /**
     * Get the value of Is Online Shopping
     *
     * @return mixed
     */
    public function getIsOnlineShopping()
    {
        return $this->isOnlineShopping;
    }

    /**
     * Set the value of Is Online Shopping
     *
     * @param mixed isOnlineShopping
     *
     * @return self
     */
    public function setIsOnlineShopping($isOnlineShopping)
    {
        $this->isOnlineShopping = $isOnlineShopping;

        return $this;
    }

    /**
     * Get the value of Is Imported
     *
     * @return mixed
     */
    public function getIsImported()
    {
        return $this->isImported;
    }

    /**
     * Set the value of Is Imported
     *
     * @param mixed isImported
     *
     * @return self
     */
    public function setIsImported($isImported)
    {
        $this->isImported = $isImported;

        return $this;
    }


    /**
     * Get the value of Product Type
     *
     * @return mixed
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * Set the value of Product Type
     *
     * @param mixed productType
     *
     * @return self
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * Get the value of Product Style Number
     *
     * @return mixed
     */
    public function getProductStyleNumber()
    {
        return $this->productStyleNumber;
    }

    /**
     * Set the value of Product Style Number
     *
     * @param mixed productStyleNumber
     *
     * @return self
     */
    public function setProductStyleNumber($productStyleNumber)
    {
        $this->productStyleNumber = $productStyleNumber;

        return $this;
    }


    /**
     * Get the value of Dim Full Extension
     *
     * @return mixed
     */
    public function getDimFullExtension()
    {
        return $this->dimFullExtension;
    }

    /**
     * Set the value of Dim Full Extension
     *
     * @param mixed dimFullExtension
     *
     * @return self
     */
    public function setDimFullExtension($dimFullExtension)
    {
        $this->dimFullExtension = $dimFullExtension;

        return $this;
    }


    /**
     * Get the value of Image Dimension
     *
     * @return mixed
     */
    public function getImageDimension()
    {
        return $this->imageDimension;
    }

    /**
     * Set the value of Image Dimension
     *
     * @param mixed imageDimension
     *
     * @return self
     */
    public function setImageDimension($imageDimension)
    {
        $this->imageDimension = $imageDimension;

        return $this;
    }

	public function removeImageDimension()
	{
		$this->setImageDimension(null);
	}

}
