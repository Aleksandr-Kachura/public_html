<?php
namespace App\FrontEndBundle\Service;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.06.15
 * Time: 8:43
 */


class SearchManager
{

    public $searchArr;

    public function __construct($container)
    {
        $this->container = $container;
    }


    public function  setSearchArr($searcharr)
    {
        $this->searchArr = $searcharr;
        return $this;
    }

    public function getSearchArr()
    {
        return $this->searchArr;
    }

    public function giveResult()
    {
        $search = $this->getSearchArr();
        $em = $this->container->get('doctrine')->getManager();
        $users=$em->getRepository("BundlesStoreBundle:User2")->findPhotogrs($search);
        return $users;
    }


    public function changetab()
    {
        $em = $this->container->get('doctrine')->getManager();
        $image = new Image();
        $str = time();
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

}