<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Review
 *
 * @ORM\Table(name="review")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ReviewRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Review
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
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="review")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $product;


    /**
    * @ORM\OneToMany(targetEntity="ReviewRating", mappedBy="review")
    */
    private $reviewRating;

    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="review")
    * @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
    */
    private $user;

    /**
    * @ORM\Column(name ="rating",type="smallint", options={"default":0})
    */
    private $ratingScore;

    /**
    * @ORM\Column(name ="title", type="string", length=255,nullable = true)
    */
    private $title;

    /**
    * @ORM\Column(name ="content",  type="text", length=65535,nullable = true)
    */
    private $content;

    /**
    * @ORM\Column(name ="reviewer_name", type="string", length=255)
    */
    private $reviewerName;

    /**
    * @ORM\Column(name ="reviewer_email", type="string", length=255,nullable = true)
    */
    private $reviewerEmail;

    /**
    * @ORM\Column(name ="ip_address", type="string", length=45)
    */
    private $ipAddress;

    /**
    * @ORM\Column(name ="user_session", type="string", length=128)
    */
    private $userSession;


    /**
    * @ORM\Column(type="smallint", options={"unsigned":true, "default":0})
    */
    private $status = 0;

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
     * Get the value of Product
     *
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set the value of Product
     *
     * @param mixed product
     *
     * @return self
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get the value of Review Rating
     *
     * @return mixed
     */
    public function getReviewRating()
    {
        return $this->reviewRating;
    }

    /**
     * Set the value of Review Rating
     *
     * @param mixed reviewRating
     *
     * @return self
     */
    public function setReviewRating($reviewRating)
    {
        $this->reviewRating = $reviewRating;

        return $this;
    }

    /**
     * Get the value of User
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of User
     *
     * @param mixed user
     *
     * @return self
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of Rating Score
     *
     * @return mixed
     */
    public function getRatingScore()
    {
        return $this->ratingScore;
    }

    /**
     * Set the value of Rating Score
     *
     * @param mixed ratingScore
     *
     * @return self
     */
    public function setRatingScore($ratingScore)
    {
        $this->ratingScore = $ratingScore;

        return $this;
    }

    /**
     * Get the value of Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param mixed title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Content
     *
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set the value of Content
     *
     * @param mixed content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get the value of Reviewer Name
     *
     * @return mixed
     */
    public function getReviewerName()
    {
        return $this->reviewerName;
    }

    /**
     * Set the value of Reviewer Name
     *
     * @param mixed reviewerName
     *
     * @return self
     */
    public function setReviewerName($reviewerName)
    {
        $this->reviewerName = $reviewerName;

        return $this;
    }

    /**
     * Get the value of Reviewer Email
     *
     * @return mixed
     */
    public function getReviewerEmail()
    {
        return $this->reviewerEmail;
    }

    /**
     * Set the value of Reviewer Email
     *
     * @param mixed reviewerEmail
     *
     * @return self
     */
    public function setReviewerEmail($reviewerEmail)
    {
        $this->reviewerEmail = $reviewerEmail;

        return $this;
    }

    /**
     * Get the value of Ip Address
     *
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set the value of Ip Address
     *
     * @param mixed ipAddress
     *
     * @return self
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get the value of User Session
     *
     * @return mixed
     */
    public function getUserSession()
    {
        return $this->userSession;
    }

    /**
     * Set the value of User Session
     *
     * @param mixed userSession
     *
     * @return self
     */
    public function setUserSession($userSession)
    {
        $this->userSession = $userSession;

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
