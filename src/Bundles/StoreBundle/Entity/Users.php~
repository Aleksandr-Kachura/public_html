<?php

namespace Bundles\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sonata\UserBundle\Entity\BaseUser;

/**
 * Users
 */
class Users extends BaseUser
{



    public function __construct()
    {
        parent::__construct();
        $this->photo = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @var integer
     */
    protected  $id;

    /**
     * @var string
     */
    protected  $firstname;

    /**
     * @var string
     */
    protected  $lastname;

    /**
     * @var string
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orders;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return Users
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Users
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Users
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Add photo
     *
     * @param \Bundles\StoreBundle\Entity\Photo $photo
     * @return Users
     */
    public function addPhoto(\Bundles\StoreBundle\Entity\Photo $photo)
    {
        $this->photo[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Bundles\StoreBundle\Entity\Photo $photo
     */
    public function removePhoto(\Bundles\StoreBundle\Entity\Photo $photo)
    {
        $this->photo->removeElement($photo);
    }

    /**
     * Get photo
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Add orders
     *
     * @param \Bundles\StoreBundle\Entity\Orders $orders
     * @return Users
     */
    public function addOrder(\Bundles\StoreBundle\Entity\Orders $orders)
    {
        $this->orders[] = $orders;

        return $this;
    }

    /**
     * Remove orders
     *
     * @param \Bundles\StoreBundle\Entity\Orders $orders
     */
    public function removeOrder(\Bundles\StoreBundle\Entity\Orders $orders)
    {
        $this->orders->removeElement($orders);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrders()
    {
        return $this->orders;
    }
}
