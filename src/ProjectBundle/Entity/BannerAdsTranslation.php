<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="banner_ads_translation")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class BannerAdsTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="text", length=65535, nullable = true)
     */
    private $website;

    /**
     *
     * @ORM\Column(name="caption_title", type="string", length=255, nullable = true)
     */
    private $captionTitle;

    /**
     * @ORM\Column(name="caption_description", type="text", length=65535, nullable = true)
     */
    private $captionDescription;

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
     * Get the value of Caption Title
     *
     * @return mixed
     */
    public function getCaptionTitle()
    {
        return $this->captionTitle;
    }

    /**
     * Set the value of Caption Title
     *
     * @param mixed captionTitle
     *
     * @return self
     */
    public function setCaptionTitle($captionTitle)
    {
        $this->captionTitle = $captionTitle;

        return $this;
    }

    /**
     * Get the value of Caption Description
     *
     * @return mixed
     */
    public function getCaptionDescription()
    {
        return $this->captionDescription;
    }

    /**
     * Set the value of Caption Description
     *
     * @param mixed captionDescription
     *
     * @return self
     */
    public function setCaptionDescription($captionDescription)
    {
        $this->captionDescription = $captionDescription;

        return $this;
    }

}
