<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * ProductOption
 *
 * @ORM\Table(name="product_option")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ProductOptionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ProductOption
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
	* @ORM\Column(type="decimal", scale=2, nullable = true, options={"default":0})
	*/
	private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $image;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 1;

    /**
     * @ORM\Column(name="default_option", type="boolean", options={"default":0})
     */
    private $defaultOption = false;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position = 0;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

  	/** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

    /**
	* @ORM\OneToMany(targetEntity="ProductOptionSub", mappedBy="productOption")
	*/
	private $productOptionSubs;

    /**
     * @ORM\ManyToOne(targetEntity="ProductOptionCategory", inversedBy="productOptions")
     * @ORM\JoinColumn(name="product_option_category_id", referencedColumnName="id", onDelete="RESTRICT")
     */
    private $productOptionCategory;

    /**
     * Many ProductOptions have Many Products.
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="productOptions")
     */
    private $products;

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __construct()
	{
		$this->productOptionSubs = new ArrayCollection();
        $this->products = new ArrayCollection();
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

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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
     * Get the value of Product Option Subs
     *
     * @return mixed
     */
    public function getProductOptionSubs()
    {
        return $this->productOptionSubs;
    }

    /**
     * Set the value of Product Option Subs
     *
     * @param mixed productOptionSubs
     *
     * @return self
     */
    public function setProductOptionSubs($productOptionSubs)
    {
        $this->productOptionSubs = $productOptionSubs;

        return $this;
    }


    /**
     * Get the value of Product Option Category
     *
     * @return mixed
     */
    public function getProductOptionCategory()
    {
        return $this->productOptionCategory;
    }

    /**
     * Set the value of Product Option Category
     *
     * @param mixed productOptionCategory
     *
     * @return self
     */
    public function setProductOptionCategory($productOptionCategory)
    {
        $this->productOptionCategory = $productOptionCategory;

        return $this;
    }

    /**
     * Get the value of Many ProductOptions have Many Products.
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set the value of Many ProductOptions have Many Products.
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
        $product->removeProductOptions($this);
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
        $product->addProductOptions($this);
    }


    /**
     * Get the value of Default Option
     *
     * @return mixed
     */
    public function getDefaultOption()
    {
        return $this->defaultOption;
    }

    /**
     * Set the value of Default Option
     *
     * @param mixed defaultOption
     *
     * @return self
     */
    public function setDefaultOption($defaultOption)
    {
        $this->defaultOption = $defaultOption;

        return $this;
    }

}
