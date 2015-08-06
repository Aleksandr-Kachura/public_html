<?php

namespace Bundles\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Photo
 */
class Photo
{

    public function __construct()
    {
         $this->setDate(new \DateTime());
    }


    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $adress;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var integer
     */
    private $userId;


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
     * Set adress
     *
     * @param string $adress
     * @return Photo
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string 
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Photo
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return Photo
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
    /**
     * @var \Bundles\StoreBundle\Entity\Users
     */
    private $users;


    /**
     * Set users
     *
     * @param \Bundles\StoreBundle\Entity\Users $users
     * @return Photo
     */
    public function setUsers(\Bundles\StoreBundle\Entity\Users $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \Bundles\StoreBundle\Entity\Users 
     */
    public function getUsers()
    {
        return $this->users;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orders;


    /**
     * Add orders
     *
     * @param \Bundles\StoreBundle\Entity\Orders $orders
     * @return Photo
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
