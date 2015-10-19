<?php

namespace App\FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SearchController extends Controller
{
    public function indexAction()
    {

        return $this->render('AppFrontEndBundle:Page:index.html.twig');
    }


    //поиск
    public function searchAction(Request $request)
    {
        $search = $request->get("search");
        $this->get('site_bundle.search')->setSearchArr($search);
        $users = $this->get('site_bundle.search')->giveResult();


       /* $login = $request->get("login");
        $city = $request->get("city");
        $country = $request->get("country");

        if(empty($login))
        {
            return $this->render('AppFrontEndBundle:Page:search.html.twig');
        }*/

        /*$em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("BundlesStoreBundle:User2");
        $users = $repo->findLog($login);*/
        return $this->render('AppFrontEndBundle:Page:search.html.twig', array('users'=>$users));
        //return $this->render('AppFrontEndBundle:Page:search.html.twig');


    }



    //пагинация
    public function paginAction(Request $request)
    {
       // $em    = $this->get('doctrine.orm.entity_manager');

        //$query = $em->createQuery($dql);BundlesStoreBundle:ProdtoOrder
        $em = $this->getDoctrine()->getManager();

        $repo =$em->getRepository("BundlesStoreBundle:Page");
        $query =$repo->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );

        // parameters to template
      //  return $this->render('AcmeMainBundle:Article:list.html.twig', array('pagination' => $pagination));
        return $this->render('AppFrontEndBundle:Page:page.html.twig', array('pagination' => $pagination));
    }


    //мультиязычность
    public function multiAction(Request $request)
    {

       $user=$this->getUser();
       $photo=$user->getPhoto();

       if(is_null($photo))
       {
           return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('user'=>$user));
       }
       return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('photo' =>$photo,'user'=>$user));
    }


}
