<?php
namespace App\FrontEndBundle\Service;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.06.15
 * Time: 8:43
 */
use Bundles\StoreBundle\Entity\Gallery;
use Bundles\StoreBundle\Entity\Image;
use Bundles\StoreBundle\Entity\Orders;
use Bundles\StoreBundle\Entity\Photo;
use Bundles\StoreBundle\Entity\WaterMark;


class Srv
{

    public function __construct($container,$securityContext)
    {
        $this->container = $container;
        $this->user = $securityContext->getToken()->getUser();
    }

    public function showAct()
    {
        $doctrine = $this->container->get('doctrine')->getManager();
        $req=$this->container->get('request');
        return ("111");
    }

   // TODO so you understand
    public function init()
    {
        $em = $this->container->get('doctrine')->getManager();
        $users=$em->getRepository("BundlesStoreBundle:User2")->findAll();
    }

    public function getlink($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $user=$em->getRepository("BundlesStoreBundle:User2")->findOneById($id);
       // /1/?ref=ab45j2

        $link = "http://mvp.intechsoft.net/reg?refferal=".$user->getReferralCode();
        return $link;
    }

    public function changetab()
    {
        $em = $this->container->get('doctrine')->getManager();
        $image = new Image();
        $str=time();
        $image->setLocation($str);
        $em->persist($image);
        $em->flush();
        return "ok";
    }

    public function prepareDate($keys)
    {
        $em = $this->container->get('doctrine')->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Orders");
        $orders=null;
        foreach($keys as $key =>$value)
        {
            if($repo->findByPhoto($value))
            {
                $orders[]=$repo->findByPhoto($value);
            }

        }
        return $orders;
    }


    // this method save photo session on table have paramers @email_user @name_photosess @ids_photo
    public function justSavePhSess($req)
    {

        $em = $this->container->get('doctrine')->getManager();
        $gallery = new Gallery();
        $name_ph = $req->get('foto_sess');
        $userEm = $req->get('user_email');
        $ids= $req->get('images');
        if(!$ids)
        {
            return "Fail";
        }
        $gallery->setName($name_ph);
        $gallery->setPhId($this->user->getId());
        $repo=$em->getRepository("BundlesStoreBundle:User2");
        $repo2=$em->getRepository("BundlesStoreBundle:Photo");
        $user = $repo->findOneByEmail($userEm);
        $gallery->setUser2($user);
        $em->persist($gallery);
        foreach($ids as $key=>$value)
        {
            $photo=$repo2->findOneById($value);
            $gallery->addPhoto($photo);
        }

        $em->flush();
        return "Ok";
       // dump($this->user->getId());
    }




    // this method display propos photosess to user, we get gallery User and get photo then display it

    public function getPropsFS()
    {
        //$em = $this->container->get('doctrine')->getManager();
        $galleries =$this->user->getGallery();
       /* $data=array();
        $phadr=array();
        foreach($galleries as $key=>$gallery)
        {
            $nameFS=$gallery->getName();
            $photograph=$gallery->getPhId();
            $idFS=$gallery->getId();
            $photos=$gallery->getPhoto();

            foreach($photos as $key=>$photo)
            {
                $phadr[]=$photo->getAdress();
            }
            $data[$nameFS]['phId']=$photograph;
            $data[$nameFS]['id']=$idFS;
            $data[$nameFS]['photos']= $phadr;

        }*/
        return($galleries);
    }

    public function delFS($id)
    {
        $em = $this->container->get('doctrine')->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Gallery");
        $fs = $repo->findOneById(array('id' => $id));
        $em->remove($fs);
        $em->flush();
        return("ok");
    }

    public function saveOrders($request)
    {

        $em = $this->container->get('doctrine')->getManager();
        $ids = $request->get('images');
        foreach($ids as $key =>$id)
        {
            $order= new Orders();
            $order->setStatus("panding");
            $order->setUser2($this->user);

            $repo=$em->getRepository("BundlesStoreBundle:Photo");
            $photo = $repo->findOneById(array('id' => $id));

            $order->setPhoto($photo);
            $em->persist($order);
        }

        $em->flush();
        return "SUCCESS";
    }

    public function saveWaterPosition($request)
    {
        $em = $this->container->get('doctrine')->getManager();
        $waterPos = $request->get('waterPos');
        if($waterPos=='Choise position')
        {
            return 'ERR';
        }
        $repo=$em->getRepository("BundlesStoreBundle:WaterMark");
        $waters =  $repo->findBy(array('user2'=>$this->user));
        if(empty($waters))
        {
            $water = new WaterMark();
            $water->setPosition($waterPos);
            $water->setUser2($this->user);
        }
        else
        {
            $water=$waters[0];
            $water->setPosition($waterPos);
        }
        $em->persist($water);
        $em->flush();

    }



}