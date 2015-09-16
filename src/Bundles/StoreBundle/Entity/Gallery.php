<?php

namespace Bundles\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gallery
 */
class Gallery
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $phId;


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
     * Set name
     *
     * @param string $name
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phId
     *
     * @param integer $phId
     * @return Gallery
     */
    public function setPhId($phId)
    {
        $this->phId = $phId;

        return $this;
    }

    /**
     * Get phId
     *
     * @return integer 
     */
    public function getPhId()
    {
        return $this->phId;
    }
    /**
     * @var \Bundles\StoreBundle\Entity\User2
     */
    private $user2;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set user2
     *
     * @param \Bundles\StoreBundle\Entity\User2 $user2
     * @return Gallery
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



    /**
     * Add photo
     *
     * @param \Bundles\StoreBundle\Entity\Photo $photo
     * @return Gallery
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
}
