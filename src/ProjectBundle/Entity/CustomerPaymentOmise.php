<?php

namespace ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CustomerPaymentOmise
 *
 * @ORM\Table(name="customer_payment_omise")
 * @ORM\Entity(repositoryClass="ProjectBundle\Repository\CustomerPaymentOmiseRepository")
 * @ORM\HasLifecycleCallbacks
 */
class CustomerPaymentOmise
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
     * @ORM\OneToOne(targetEntity="CustomerOrder", inversedBy="customerPaymentOmise")
     * @ORM\JoinColumn(name="customer_order_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $customerOrder;

    /**
	 * @ORM\Column(name="amount", type="decimal", scale=2)
	 */
	private $amount;

    /**
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(name="token_id", type="string", length=255, nullable = true)
     */
    private $tokenId;

    /**
     * @ORM\Column(name="currency", type="string", length=255, nullable = true)
     */
    private $currency;

    /**
	* @ORM\Column(name="authorized", type="smallint", nullable = true)
	*/
	private $authorized;

    /**
	* @ORM\Column(name="paid", type="smallint", nullable = true)
	*/
	private $paid;

    /**
     * @ORM\Column(name="card_id", type="string", length=255, nullable = true)
     */
    private $cardId;

    /**
     * @ORM\Column(name="card_country", type="string", length=255, nullable = true)
     */
    private $cardCountry;

    /**
     * @ORM\Column(name="card_bank", type="string", length=255, nullable = true)
     */
    private $cardBank;

    /**
     * @ORM\Column(name="card_last_digits", type="string", length=255, nullable = true)
     */
    private $cardLastDigits;

    /**
     * @ORM\Column(name="card_brand", type="string", length=255, nullable = true)
     */
    private $cardBrand;

    /**
     * @ORM\Column(name="card_expiration_month", type="string", length=255, nullable = true)
     */
    private $cardExpirationMonth;

    /**
     * @ORM\Column(name="card_expiration_year", type="string", length=255, nullable = true)
     */
    private $cardExpirationYear;

    /**
     * @ORM\Column(name="card_name", type="string", length=255, nullable = true)
     */
    private $cardName;

    /**
     * @ORM\Column(name="failure_code", type="string", length=255, nullable = true)
     */
    private $failureCode;

    /**
     * @ORM\Column(name="failure_message", type="string", length=255, nullable = true)
     */
    private $failureMessage;

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
     * Get the value of Customer Order
     *
     * @return mixed
     */
    public function getCustomerOrder()
    {
        return $this->customerOrder;
    }

    /**
     * Set the value of Customer Order
     *
     * @param mixed customerOrder
     *
     * @return self
     */
    public function setCustomerOrder($customerOrder)
    {
        $this->customerOrder = $customerOrder;

        return $this;
    }

    /**
     * Get the value of Amount
     *
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of Amount
     *
     * @param mixed amount
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

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
     * Get the value of Token Id
     *
     * @return mixed
     */
    public function getTokenId()
    {
        return $this->tokenId;
    }

    /**
     * Set the value of Token Id
     *
     * @param mixed tokenId
     *
     * @return self
     */
    public function setTokenId($tokenId)
    {
        $this->tokenId = $tokenId;

        return $this;
    }

    /**
     * Get the value of Currency
     *
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of Currency
     *
     * @param mixed currency
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get the value of Authorized
     *
     * @return mixed
     */
    public function getAuthorized()
    {
        return $this->authorized;
    }

    /**
     * Set the value of Authorized
     *
     * @param mixed authorized
     *
     * @return self
     */
    public function setAuthorized($authorized)
    {
        $this->authorized = $authorized;

        return $this;
    }

    /**
     * Get the value of Paid
     *
     * @return mixed
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set the value of Paid
     *
     * @param mixed paid
     *
     * @return self
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get the value of Card Id
     *
     * @return mixed
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * Set the value of Card Id
     *
     * @param mixed cardId
     *
     * @return self
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;

        return $this;
    }

    /**
     * Get the value of Card Country
     *
     * @return mixed
     */
    public function getCardCountry()
    {
        return $this->cardCountry;
    }

    /**
     * Set the value of Card Country
     *
     * @param mixed cardCountry
     *
     * @return self
     */
    public function setCardCountry($cardCountry)
    {
        $this->cardCountry = $cardCountry;

        return $this;
    }

    /**
     * Get the value of Card Bank
     *
     * @return mixed
     */
    public function getCardBank()
    {
        return $this->cardBank;
    }

    /**
     * Set the value of Card Bank
     *
     * @param mixed cardBank
     *
     * @return self
     */
    public function setCardBank($cardBank)
    {
        $this->cardBank = $cardBank;

        return $this;
    }

    /**
     * Get the value of Card Last Digits
     *
     * @return mixed
     */
    public function getCardLastDigits()
    {
        return $this->cardLastDigits;
    }

    /**
     * Set the value of Card Last Digits
     *
     * @param mixed cardLastDigits
     *
     * @return self
     */
    public function setCardLastDigits($cardLastDigits)
    {
        $this->cardLastDigits = $cardLastDigits;

        return $this;
    }

    /**
     * Get the value of Card Brand
     *
     * @return mixed
     */
    public function getCardBrand()
    {
        return $this->cardBrand;
    }

    /**
     * Set the value of Card Brand
     *
     * @param mixed cardBrand
     *
     * @return self
     */
    public function setCardBrand($cardBrand)
    {
        $this->cardBrand = $cardBrand;

        return $this;
    }

    /**
     * Get the value of Card Expiration Month
     *
     * @return mixed
     */
    public function getCardExpirationMonth()
    {
        return $this->cardExpirationMonth;
    }

    /**
     * Set the value of Card Expiration Month
     *
     * @param mixed cardExpirationMonth
     *
     * @return self
     */
    public function setCardExpirationMonth($cardExpirationMonth)
    {
        $this->cardExpirationMonth = $cardExpirationMonth;

        return $this;
    }

    /**
     * Get the value of Card Expiration Year
     *
     * @return mixed
     */
    public function getCardExpirationYear()
    {
        return $this->cardExpirationYear;
    }

    /**
     * Set the value of Card Expiration Year
     *
     * @param mixed cardExpirationYear
     *
     * @return self
     */
    public function setCardExpirationYear($cardExpirationYear)
    {
        $this->cardExpirationYear = $cardExpirationYear;

        return $this;
    }

    /**
     * Get the value of Card Name
     *
     * @return mixed
     */
    public function getCardName()
    {
        return $this->cardName;
    }

    /**
     * Set the value of Card Name
     *
     * @param mixed cardName
     *
     * @return self
     */
    public function setCardName($cardName)
    {
        $this->cardName = $cardName;

        return $this;
    }

    /**
     * Get the value of Failure Code
     *
     * @return mixed
     */
    public function getFailureCode()
    {
        return $this->failureCode;
    }

    /**
     * Set the value of Failure Code
     *
     * @param mixed failureCode
     *
     * @return self
     */
    public function setFailureCode($failureCode)
    {
        $this->failureCode = $failureCode;

        return $this;
    }

    /**
     * Get the value of Failure Message
     *
     * @return mixed
     */
    public function getFailureMessage()
    {
        return $this->failureMessage;
    }

    /**
     * Set the value of Failure Message
     *
     * @param mixed failureMessage
     *
     * @return self
     */
    public function setFailureMessage($failureMessage)
    {
        $this->failureMessage = $failureMessage;

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
