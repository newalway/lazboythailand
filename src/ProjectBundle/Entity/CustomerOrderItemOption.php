<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrderItemOption
 *
 * @ORM\Table(name="customer_order_item_option")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\CustomerOrderItemOptionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CustomerOrderItemOption
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
	* @ORM\Column(name="option_id", type="integer")
	*/
	private $optionId;

    /**
	* @ORM\Column(name="option_title", type="string", length=255)
	*/
	private $optionTitle;

    /**
	* @ORM\Column(name="option_image", type="string", length=255, nullable = true)
	*/
	private $optionImage;

    /**
	* @ORM\Column(name="option_price", type="decimal", scale=2)
	*/
	private $optionPrice = 0;

    /**
	* @ORM\Column(name="option_category_id", type="integer", nullable = true)
	*/
	private $optionCategoryId;

    /**
	* @ORM\Column(name="option_category_title", type="string", length=255, nullable = true)
	*/
	private $optionCategoryTitle;

    /**
	* @ORM\Column(name="option_category_image", type="string", length=255, nullable = true)
	*/
	private $optionCategoryImage;

    /**
	* @ORM\OneToMany(targetEntity="CustomerOrderItemOptionSub", mappedBy="customerOrderItemOption")
	*/
	private $customerOrderItemOptionSubs;

    /**
     * @ORM\ManyToOne(targetEntity="CustomerOrderItem", inversedBy="customerOrderItemOptions")
     * @ORM\JoinColumn(name="customer_order_item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $customerOrderItem;

	/** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
	private $updatedAt;

	/** @ORM\Column(name="created_at", type="datetime") */
	private $createdAt;

    public function __construct()
	{
		$this->customerOrderItemOptionSubs = new ArrayCollection();
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
     * Get the value of Option Id
     *
     * @return mixed
     */
    public function getOptionId()
    {
        return $this->optionId;
    }

    /**
     * Set the value of Option Id
     *
     * @param mixed optionId
     *
     * @return self
     */
    public function setOptionId($optionId)
    {
        $this->optionId = $optionId;

        return $this;
    }

    /**
     * Get the value of Option Title
     *
     * @return mixed
     */
    public function getOptionTitle()
    {
        return $this->optionTitle;
    }

    /**
     * Set the value of Option Title
     *
     * @param mixed optionTitle
     *
     * @return self
     */
    public function setOptionTitle($optionTitle)
    {
        $this->optionTitle = $optionTitle;

        return $this;
    }

    /**
     * Get the value of Option Image
     *
     * @return mixed
     */
    public function getOptionImage()
    {
        return $this->optionImage;
    }

    /**
     * Set the value of Option Image
     *
     * @param mixed optionImage
     *
     * @return self
     */
    public function setOptionImage($optionImage)
    {
        $this->optionImage = $optionImage;

        return $this;
    }

    /**
     * Get the value of Option Price
     *
     * @return mixed
     */
    public function getOptionPrice()
    {
        return $this->optionPrice;
    }

    /**
     * Set the value of Option Price
     *
     * @param mixed optionPrice
     *
     * @return self
     */
    public function setOptionPrice($optionPrice)
    {
        $this->optionPrice = $optionPrice;

        return $this;
    }

    /**
     * Get the value of Option Category Id
     *
     * @return mixed
     */
    public function getOptionCategoryId()
    {
        return $this->optionCategoryId;
    }

    /**
     * Set the value of Option Category Id
     *
     * @param mixed optionCategoryId
     *
     * @return self
     */
    public function setOptionCategoryId($optionCategoryId)
    {
        $this->optionCategoryId = $optionCategoryId;

        return $this;
    }

    /**
     * Get the value of Option Category Title
     *
     * @return mixed
     */
    public function getOptionCategoryTitle()
    {
        return $this->optionCategoryTitle;
    }

    /**
     * Set the value of Option Category Title
     *
     * @param mixed optionCategoryTitle
     *
     * @return self
     */
    public function setOptionCategoryTitle($optionCategoryTitle)
    {
        $this->optionCategoryTitle = $optionCategoryTitle;

        return $this;
    }

    /**
     * Get the value of Option Category Image
     *
     * @return mixed
     */
    public function getOptionCategoryImage()
    {
        return $this->optionCategoryImage;
    }

    /**
     * Set the value of Option Category Image
     *
     * @param mixed optionCategoryImage
     *
     * @return self
     */
    public function setOptionCategoryImage($optionCategoryImage)
    {
        $this->optionCategoryImage = $optionCategoryImage;

        return $this;
    }

    /**
     * Get the value of Customer Order Item Option Subs
     *
     * @return mixed
     */
    public function getCustomerOrderItemOptionSubs()
    {
        return $this->customerOrderItemOptionSubs;
    }

    /**
     * Set the value of Customer Order Item Option Subs
     *
     * @param mixed customerOrderItemOptionSubs
     *
     * @return self
     */
    public function setCustomerOrderItemOptionSubs($customerOrderItemOptionSubs)
    {
        $this->customerOrderItemOptionSubs = $customerOrderItemOptionSubs;

        return $this;
    }

    /**
     * Get the value of Customer Order Item
     *
     * @return mixed
     */
    public function getCustomerOrderItem()
    {
        return $this->customerOrderItem;
    }

    /**
     * Set the value of Customer Order Item
     *
     * @param mixed customerOrderItem
     *
     * @return self
     */
    public function setCustomerOrderItem($customerOrderItem)
    {
        $this->customerOrderItem = $customerOrderItem;

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

}
