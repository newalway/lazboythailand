<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
#use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * @ORM\Table(name="product_category_translation", indexes={@ORM\Index(name="search_idx", columns={"title"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class ProductCategoryTranslation
{
    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="short_desc", type="text", length=65535, nullable = true)
     */
    private $shortDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable = true)
     */
    private $description;

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

    // /**
    //  * @ORM\PostUpdate
    //  * @ORM\PostPersist
    //  */
    /*
    public function updateSlug(LifecycleEventArgs $eventArgs)
    {
        // updateSlug for different slug entity (title in ProductCategoryTranslation, slug in ProductCategory)
        // slug updated when updating translation

        // $translatable = $this->getTranslatable();
        // $oldSlug = $translatable->getSlug();
        // $translatable->generateSlug();
        // $newSlug = $translatable->getSlug();
        // if ($oldSlug !== $newSlug) {
            // $id = $translatable->getId();
            // $em = $eventArgs->getEntityManager();
            // $data = $em->getRepository(get_class($translatable))->find($id);
            // $data->setSlug($newSlug);
            // $em->flush();

            // // $repo = $eventArgs->getEntityManager()->getRepository(get_class($translatable));
            // // $data = $repo->find($id);
            // // $data->setSlug($newSlug);
            // // $em->flush();
        // }
    }
    */


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
     * Get the value of Short Desc
     *
     * @return mixed
     */
    public function getShortDesc()
    {
        return $this->shortDesc;
    }

    /**
     * Set the value of Short Desc
     *
     * @param mixed shortDesc
     *
     * @return self
     */
    public function setShortDesc($shortDesc)
    {
        $this->shortDesc = $shortDesc;

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
