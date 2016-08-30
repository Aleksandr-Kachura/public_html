<?php

namespace Bundles\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User2
 */
class User2 implements UserInterface
{
    public  function getSalt()
    {
        return $this->salt;
    }

    public function getRoles()
    {
        if($this->getUsername()==="admin")
        {
            return array('ROLE_ADMIN');
        }
        else
        {
            return array('ROLE_USER');
        }
    }
    public function eraseCredentials()
    {

    }


    /**
     * @var integer
     */


    private $id;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $email;


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
     * @return User2
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
     * @return User2
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
     * Set username
     *
     * @param string $username
     * @return User2
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User2
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User2
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $img;


    /**
     * Set status
     *
     * @param string $status
     * @return User2
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
     * Set img
     *
     * @param string $img
     * @return User2
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get img
     *
     * @return string 
     */
    public function getImg()
    {
        return $this->img;
    }
    /**
     * @var string
     */
    protected $salt;


    /**
     * Set salt
     *
     * @param string $salt
     * @return User2
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $photo;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $orders;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photo = new \Doctrine\Common\Collections\ArrayCollection();
        $this->orders = new \Doctrine\Common\Collections\ArrayCollection();
        $this->referralCode = self::generateReferralCode();
    }

    /**
     * Add photo
     *
     * @param \Bundles\StoreBundle\Entity\Photo $photo
     * @return User2
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
     * @return User2
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
    /**
     * @var string
     */
    private $referralCode;


    /**
     * Set referralCode
     *
     * @param string $referralCode
     * @return User2
     */
    public function setReferralCode($referralCode)
    {
        $this->referralCode = $referralCode;

        return $this;
    }

    /**
     * Get referralCode
     *
     * @return string 
     */
    public function getReferralCode()
    {
        return $this->referralCode;
    }

    /**
     * Generates referral code
     *
     * @param int $length
     * @return string
     * TODO: Can be extracted to separate service for better flexebility
     */
    static protected function generateReferralCode($length=6)
    {
        $hex = md5("yourSaltHere" . uniqid("", true));

        $pack = pack('H*', $hex);
        $tmp =  base64_encode($pack);

        $uid = preg_replace("#(*UTF8)[^A-Za-z0-9]#", "", $tmp);

        $len = max(4, min(128, $length));

        while (strlen($uid) < $len)
            $uid .= self::generateReferralCode(22);

        return substr($uid, 0, $length);
    }

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $stat;


    /**
     * Add stat
     *
     * @param \Bundles\StoreBundle\Entity\Orders $stat
     * @return User2
     */
    public function addStat(\Bundles\StoreBundle\Entity\Orders $stat)
    {
        $this->stat[] = $stat;

        return $this;
    }

    /**
     * Remove stat
     *
     * @param \Bundles\StoreBundle\Entity\Orders $stat
     */
    public function removeStat(\Bundles\StoreBundle\Entity\Orders $stat)
    {
        $this->stat->removeElement($stat);
    }

    /**
     * Get stat
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStat()
    {
        return $this->stat;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $gallery;


    /**
     * Add gallery
     *
     * @param \Bundles\StoreBundle\Entity\Gallery $gallery
     * @return User2
     */
    public function addGallery(\Bundles\StoreBundle\Entity\Gallery $gallery)
    {
        $this->gallery[] = $gallery;

        return $this;
    }

    /**
     * Remove gallery
     *
     * @param \Bundles\StoreBundle\Entity\Gallery $gallery
     */
    public function removeGallery(\Bundles\StoreBundle\Entity\Gallery $gallery)
    {
        $this->gallery->removeElement($gallery);
    }

    /**
     * Get gallery
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGallery()
    {
        return $this->gallery;
    }
    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $country;


    /**
     * Set city
     *
     * @param string $city
     * @return User2
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return User2
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * @var string
     */
    private $descTech;


    /**
     * Set descTech
     *
     * @param string $descTech
     * @return User2
     */
    public function setDescTech($descTech)
    {
        $this->descTech = $descTech;

        return $this;
    }

    /**
     * Get descTech
     *
     * @return string 
     */
    public function getDescTech()
    {
        return $this->descTech;
    }
}
