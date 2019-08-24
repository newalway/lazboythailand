<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerOrderItemOptionSub
 *
 * @ORM\Table(name="customer_order_item_option_sub")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\CustomerOrderItemOptionSubRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CustomerOrderItemOptionSub
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
	* @ORM\Column(name="title", type="string", length=255)
	*/
	private $title;

    /**
	* @ORM\Column(type="string", length=255, nullable = true)
	*/
	private $image;

    /**
     * @ORM\ManyToOne(targetEntity="CustomerOrderItemOption", inversedBy="customerOrderItemOptionSubs")
     * @ORM\JoinColumn(name="customer_order_item_option_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $customerOrderItemOption;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

  	/** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

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
}
