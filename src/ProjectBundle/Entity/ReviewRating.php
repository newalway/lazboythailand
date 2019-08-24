<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReviewRating
 *
 * @ORM\Table(name="review_rating")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\ReviewRatingRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ReviewRating
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
    * @ORM\ManyToOne(targetEntity="User", inversedBy="reviewRating")
    * @ORM\JoinColumn(name="fos_user_id", referencedColumnName="id")
    */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Review", inversedBy="reviewRating")
     * @ORM\JoinColumn(name="review_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $review;

    /**
    * @ORM\Column(name ="helpful",type="smallint")
    */
    private $helpful;

    /**
    * @ORM\Column(name ="unhelpful",type="smallint")
    */
    private $unhelpful;

    /**
    * @ORM\Column(name ="ip_address", type="string", length=45)
    */
    private $ipAddress;

    /**
    * @ORM\Column(name ="user_session", type="string", length=128)
    */
    private $userSession;

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
     * Get the value of Review
     *
     * @return mixed
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * Set the value of Review
     *
     * @param mixed review
     *
     * @return self
     */
    public function setReview($review)
    {
        $this->review = $review;

        return $this;
    }

    /**
     * Get the value of Helpful
     *
     * @return mixed
     */
    public function getHelpful()
    {
        return $this->helpful;
    }

    /**
     * Set the value of Helpful
     *
     * @param mixed helpful
     *
     * @return self
     */
    public function setHelpful($helpful)
    {
        $this->helpful = $helpful;

        return $this;
    }

    /**
     * Get the value of Unhelpful
     *
     * @return mixed
     */
    public function getUnhelpful()
    {
        return $this->unhelpful;
    }

    /**
     * Set the value of Unhelpful
     *
     * @param mixed unhelpful
     *
     * @return self
     */
    public function setUnhelpful($unhelpful)
    {
        $this->unhelpful = $unhelpful;

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
