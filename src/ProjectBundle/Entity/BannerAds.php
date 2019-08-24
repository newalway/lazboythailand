<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * BannerAds
 *
 * @ORM\Table(name="banner_ads")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\BannerAdsRepository")
 * @ORM\HasLifecycleCallbacks
 */
class BannerAds
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
     * @ORM\Column(name="banner_name", type="string", length=255)
     */
    private $bannerName;

    /**
     * @ORM\Column(name="banner_value", type="string", length=255, nullable = true)
     */
    private $bannerValue;

    /**
     * @ORM\Column(name="banner_url", type="string", length=255, nullable = true)
     */
    private $bannerUrl;

    /**
     * @ORM\Column(name="banner_group", type="string", length=255, nullable = true)
     */
    private $bannerGroup;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $image;

    /**
     * @ORM\Column(name="image_size", type="string", length=255, nullable = true)
     */
    private $imageSize;

    /**
     * @ORM\Column(name="image_mobile",type="string", length=255, nullable = true)
     */
    private $imageMobile;

    /**
     * @ORM\Column(name="image_mobile_size", type="string", length=255, nullable = true)
     */
    private $imageMobileSize;


    /** @ORM\Column(name="updated_at", type="datetime", nullable = true) */
    private $updatedAt;

    /** @ORM\Column(name="created_at", type="datetime") */
    private $createdAt;

    /**
     * @ORM\Column(type="smallint")
     */
    private $position = 0;

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

    public function __call($method, $arguments)
    {
        return $this->proxyCurrentLocaleTranslation($method, $arguments);
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
     * Get the value of Banner Name
     *
     * @return mixed
     */
    public function getBannerName()
    {
        return $this->bannerName;
    }

    /**
     * Set the value of Banner Name
     *
     * @param mixed bannerName
     *
     * @return self
     */
    public function setBannerName($bannerName)
    {
        $this->bannerName = $bannerName;

        return $this;
    }

    /**
     * Get the value of Banner Value
     *
     * @return mixed
     */
    public function getBannerValue()
    {
        return $this->bannerValue;
    }

    /**
     * Set the value of Banner Value
     *
     * @param mixed bannerValue
     *
     * @return self
     */
    public function setBannerValue($bannerValue)
    {
        $this->bannerValue = $bannerValue;

        return $this;
    }

    /**
     * Get the value of Banner Url
     *
     * @return mixed
     */
    public function getBannerUrl()
    {
        return $this->bannerUrl;
    }

    /**
     * Set the value of Banner Url
     *
     * @param mixed bannerUrl
     *
     * @return self
     */
    public function setBannerUrl($bannerUrl)
    {
        $this->bannerUrl = $bannerUrl;

        return $this;
    }

    /**
     * Get the value of Banner Group
     *
     * @return mixed
     */
    public function getBannerGroup()
    {
        return $this->bannerGroup;
    }

    /**
     * Set the value of Banner Group
     *
     * @param mixed bannerGroup
     *
     * @return self
     */
    public function setBannerGroup($bannerGroup)
    {
        $this->bannerGroup = $bannerGroup;

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
     * Get the value of Image Size
     *
     * @return mixed
     */
    public function getImageSize()
    {
        return $this->imageSize;
    }

    /**
     * Set the value of Image Size
     *
     * @param mixed imageSize
     *
     * @return self
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * Get the value of Image Mobile
     *
     * @return mixed
     */
    public function getImageMobile()
    {
        return $this->imageMobile;
    }

    /**
     * Set the value of Image Mobile
     *
     * @param mixed imageMobile
     *
     * @return self
     */
    public function setImageMobile($imageMobile)
    {
        $this->imageMobile = $imageMobile;

        return $this;
    }

    public function removeImageMobile()
	{
		$this->setImageMobile(null);
	}

    /**
     * Get the value of Image Mobile Size
     *
     * @return mixed
     */
    public function getImageMobileSize()
    {
        return $this->imageMobileSize;
    }

    /**
     * Set the value of Image Mobile Size
     *
     * @param mixed imageMobileSize
     *
     * @return self
     */
    public function setImageMobileSize($imageMobileSize)
    {
        $this->imageMobileSize = $imageMobileSize;

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

}
