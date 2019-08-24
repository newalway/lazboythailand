<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Inspiration
 *
 * @ORM\Table(name="inspiration")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\InspirationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Inspiration
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
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="embed", type="text", length=16777215, nullable=true)
     */
    private $embed;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 1;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

    /** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position = 0;

    /**
	* Many Inspiration have Many Product.
	* @ORM\ManyToMany(targetEntity="Product", inversedBy="inspirations")
	* @ORM\JoinTable(name="inspirations_products")
	*/
	private $products;

    /**
	* @ORM\ManyToOne(targetEntity="InspirationCategory", inversedBy="inspirations")
	* @ORM\JoinColumn(name="inspiration_category_id", referencedColumnName="id", onDelete="RESTRICT")
	*/
	private $inspirationCategory;

    /**
	* @ORM\Column(name="is_highlight", type="boolean", options={"default":0})
	*/
	private $isHighlight = false;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
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
     * Get the value of Id
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
     * Get the value of Many Inspiration have Many Product.
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set the value of Many Inspiration have Many Product.
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
		$products->removeInspirations($this);
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
		$products->addInspirations($this);
	}



    /**
     * Get the value of Embed
     *
     * @return string
     */
    public function getEmbed()
    {
        return $this->embed;
    }

    /**
     * Set the value of Embed
     *
     * @param string embed
     *
     * @return self
     */
    public function setEmbed($embed)
    {
        $this->embed = $embed;

        return $this;
    }

    /**
     * Get the value of Is Highlight
     *
     * @return mixed
     */
    public function getIsHighlight()
    {
        return $this->isHighlight;
    }

    /**
     * Set the value of Is Highlight
     *
     * @param mixed isHighlight
     *
     * @return self
     */
    public function setIsHighlight($isHighlight)
    {
        $this->isHighlight = $isHighlight;

        return $this;
    }

    /**
     * Get the value of Inspiration Category
     *
     * @return mixed
     */
    public function getInspirationCategory()
    {
        return $this->inspirationCategory;
    }

    /**
     * Set the value of Inspiration Category
     *
     * @param mixed inspirationCategory
     *
     * @return self
     */
    public function setInspirationCategory($inspirationCategory)
    {
        $this->inspirationCategory = $inspirationCategory;

        return $this;
    }

}
