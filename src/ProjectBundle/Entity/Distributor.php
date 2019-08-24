<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Distributor
 *
 * @ORM\Table(name="distributor")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\DistributorRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Distributor
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
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $website;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status = 1;

    /**
    * @ORM\ManyToOne(targetEntity="Zone", inversedBy="distributor")
    * @ORM\JoinColumn(name="zone_id", referencedColumnName="id", onDelete="RESTRICT")
    */
    private $zone;

    /**
    * @ORM\ManyToOne(targetEntity="DistributorCategory", inversedBy="distributor")
    * @ORM\JoinColumn(name="distributor_category_id", referencedColumnName="id", onDelete="RESTRICT")
    */
    private $distributorCategory;

    /**
    * @ORM\OneToMany(targetEntity="DistributorImage", mappedBy="distributor")
    */
    private $distributorImage;

    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

    /** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;


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
     * Get the value of Zone
     *
     * @return mixed
     */
    public function getZone()
    {
        return $this->zone;
    }

    /**
     * Set the value of Zone
     *
     * @param mixed zone
     *
     * @return self
     */
    public function setZone($zone)
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * Get the value of Distributor Category
     *
     * @return mixed
     */
    public function getDistributorCategory()
    {
        return $this->distributorCategory;
    }

    /**
     * Set the value of Distributor Category
     *
     * @param mixed distributorCategory
     *
     * @return self
     */
    public function setDistributorCategory($distributorCategory)
    {
        $this->distributorCategory = $distributorCategory;

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

    /**
     * Get the value of Website
     *
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set the value of Website
     *
     * @param mixed website
     *
     * @return self
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }


    /**
     * Get the value of Distributor Image
     *
     * @return mixed
     */
    public function getDistributorImage()
    {
        return $this->distributorImage;
    }

    /**
     * Set the value of Distributor Image
     *
     * @param mixed distributorImage
     *
     * @return self
     */
    public function setDistributorImage($distributorImage)
    {
        $this->distributorImage = $distributorImage;

        return $this;
    }

}