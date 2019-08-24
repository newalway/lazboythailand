<?php

namespace ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Showroom
 *
 * @ORM\Table(name="showroom")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ShowroomRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Showroom
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
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $longitude;

    /**
     * @ORM\Column(name="place_id", type="string", length=255, nullable = true)
     */
    private $placeId;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $mobile;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $email;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 1;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $openDays;

    /**
    * @ORM\Column(type="time",nullable=true)
    */
    private $openTime;

    /**
    * @ORM\Column(type="time",nullable=true)
    */
    private $closeTime;

    /**
     * @ORM\Column(type="smallint")
     */
    private $set_show_to_contact = 1;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

  	/** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

    /**
    * @ORM\OneToMany(targetEntity="ShowroomImage", mappedBy="showroom")
    */
    private $showroomImage;

    /**
     * Many Showroom have Many Products.
     * @ORM\ManyToMany(targetEntity="Product", mappedBy="showrooms")
     */
    private $products;

    /**
     * Many Showrooms have Many Promotions.
     * @ORM\ManyToMany(targetEntity="Promotion", mappedBy="showrooms")
     */
    private $promotions;

    /**
	* @ORM\Column(name="is_highlight", type="boolean", options={"default":0})
	*/
	private $isHighlight = false;

    /**
     * @ORM\Column(name="position_is_highlight", type="smallint")
     */
    private $positionIsHighlight = 0;

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
    }

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getSluggableFields()
    {
        return ['titleslug'];
    }

    //method for getSluggableFields
    public function getTitleslug()
    {
        // get english title for slug generation
        return $this->translate('en')->getTitle();
        // get the title translation in current locale
        // return $this->translate(null,true)->getTitle();
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

    /**
     * Get the value of Latitude
     *
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set the value of Latitude
     *
     * @param mixed latitude
     *
     * @return self
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get the value of Longitude
     *
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set the value of Longitude
     *
     * @param mixed longitude
     *
     * @return self
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get the value of Phone
     *
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set the value of Phone
     *
     * @param mixed phone
     *
     * @return self
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of Fax
     *
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set the value of Fax
     *
     * @param mixed fax
     *
     * @return self
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get the value of Mobile
     *
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set the value of Mobile
     *
     * @param mixed mobile
     *
     * @return self
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

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
     * Get the value of Many Showroom have Many Products.
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set the value of Many Showroom have Many Products.
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
        $product->removeShowrooms($this);
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
        $product->addShowrooms($this);
    }


    /**
     * Get the value of Place Id
     *
     * @return mixed
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**
     * Set the value of Place Id
     *
     * @param mixed placeId
     *
     * @return self
     */
    public function setPlaceId($placeId)
    {
        $this->placeId = $placeId;

        return $this;
    }


    /**
     * Get the value of Many Showrooms have Many Promotions.
     *
     * @return mixed
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * Set the value of Many Showrooms have Many Promotions.
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
        $promotion->removeShowrooms($this);
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
        $promotion->addShowrooms($this);
    }


    /**
     * Get the value of Showroom Images
     *
     * @return mixed
     */
    public function getShowroomImages()
    {
        return $this->showroomImages;
    }

    /**
     * Set the value of Showroom Images
     *
     * @param mixed showroomImages
     *
     * @return self
     */
    public function setShowroomImages($showroomImages)
    {
        $this->showroomImages = $showroomImages;

        return $this;
    }


    /**
     * Get the value of Showroom Image
     *
     * @return mixed
     */
    public function getShowroomImage()
    {
        return $this->showroomImage;
    }

    /**
     * Set the value of Showroom Image
     *
     * @param mixed showroomImage
     *
     * @return self
     */
    public function setShowroomImage($showroomImage)
    {
        $this->showroomImage = $showroomImage;

        return $this;
    }

    /**
     * Get the value of Open Days
     *
     * @return mixed
     */
    public function getOpenDays()
    {
        return $this->openDays;
    }

    /**
     * Set the value of Open Days
     *
     * @param mixed openDays
     *
     * @return self
     */
    public function setOpenDays($openDays)
    {
        $this->openDays = $openDays;

        return $this;
    }

    /**
     * Get the value of Open Time
     *
     * @return mixed
     */
    public function getOpenTime()
    {
        return $this->openTime;
    }

    /**
     * Set the value of Open Time
     *
     * @param mixed openTime
     *
     * @return self
     */
    public function setOpenTime($openTime)
    {
        $this->openTime = $openTime;

        return $this;
    }

    /**
     * Get the value of Close Time
     *
     * @return mixed
     */
    public function getCloseTime()
    {
        return $this->closeTime;
    }

    /**
     * Set the value of Close Time
     *
     * @param mixed closeTime
     *
     * @return self
     */
    public function setCloseTime($closeTime)
    {
        $this->closeTime = $closeTime;

        return $this;
    }

    /**
     * Get the value of Set Show To Contact
     *
     * @return mixed
     */
    public function getSetShowToContact()
    {
        return $this->set_show_to_contact;
    }

    /**
     * Set the value of Set Show To Contact
     *
     * @param mixed set_show_to_contact
     *
     * @return self
     */
    public function setSetShowToContact($set_show_to_contact)
    {
        $this->set_show_to_contact = $set_show_to_contact;

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
     * Get the value of Position Is Highlight
     *
     * @return mixed
     */
    public function getPositionIsHighlight()
    {
        return $this->positionIsHighlight;
    }

    /**
     * Set the value of Position Is Highlight
     *
     * @param mixed positionIsHighlight
     *
     * @return self
     */
    public function setPositionIsHighlight($positionIsHighlight)
    {
        $this->positionIsHighlight = $positionIsHighlight;

        return $this;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of Email
     *
     * @param mixed email
     *
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

}
