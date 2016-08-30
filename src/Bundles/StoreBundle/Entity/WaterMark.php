<?php

namespace Bundles\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WaterMark
 */
class WaterMark
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $position;


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
     * Set position
     *
     * @param string $position
     * @return WaterMark
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string 
     */
    public function getPosition()
    {
        return $this->position;
    }
    /**
     * @var \Bundles\StoreBundle\Entity\User2
     */
    private $user2;


    /**
     * Set user2
     *
     * @param \Bundles\StoreBundle\Entity\User2 $user2
     * @return WaterMark
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
