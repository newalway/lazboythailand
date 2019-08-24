<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * DistributorTranslation
 *
 * @ORM\Table(name="distributor_translation")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\DistributorTranslationRepository")
 * @ORM\HasLifecycleCallbacks
 */
class DistributorTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
    * @var string
    *
    * @ORM\Column(type="text", length=65535, nullable = true)
    */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    private $province;



    /**
     * Get the value of Title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param string title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param string description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of Address
     *
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set the value of Address
     *
     * @param mixed address
     *
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }


    /**
     * Get the value of Province
     *
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Set the value of Province
     *
     * @param mixed province
     *
     * @return self
     */
    public function setProvince($province)
    {
        $this->province = $province;

        return $this;
    }

}