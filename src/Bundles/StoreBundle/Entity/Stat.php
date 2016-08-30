<?php

namespace Bundles\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stat
 */
class Stat
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $userId;

    /**
     * @var integer
     */
    private $refId;


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
     * Set userId
     *
     * @param integer $userId
     * @return Stat
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
     * Set refId
     *
     * @param integer $refId
     * @return Stat
     */
    public function setRefId($refId)
    {
        $this->refId = $refId;

        return $this;
    }

    /**
     * Get refId
     *
     * @return integer 
     */
    public function getRefId()
    {
        return $this->refId;
    }
    /**
     * @var \Bundles\StoreBundle\Entity\User2
     */
    private $user2;


    /**
     * Set user2
     *
     * @param \Bundles\StoreBundle\Entity\User2 $user2
     * @return Stat
     */
    public function setUser2(\Bundles\StoreBundle\Entity\User2 $user2 = null)
    {
        $this->user2 = $user2;

        return $this;
    }

    /**
     * Get user2
     *
     * @return \Bundles\StoreBundle\Entity\User2 
     */
    public function getUser2()
    {
        return $this->user2;
    }
}
