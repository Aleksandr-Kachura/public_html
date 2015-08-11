<?php

namespace App\FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Bundles\StoreBundle\Entity\Users;
use Bundles\StoreBundle\Entity\User2;

use Bundles\StoreBundle\Entity\Orders;
use Bundles\StoreBundle\Entity\Photo;
class PageController extends Controller
{
    public function indexAction()
    {
        $user=$this->getUser();
        //dump($user->getId());
        if(is_null($user))
        {
            return $this->render('AppFrontEndBundle:Page:index.html.twig');
        }
        return $this->render('AppFrontEndBundle:Page:index.html.twig',array('user'=>$user));
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

    //хлебные крошки
    public function breadAction()
    {
        $router = $this->get('router');
        $breadcrumbs = $this->get('white_october_breadcrumbs');
        $breadcrumbs->addItem('Главная', $router->generate('app_front_end_wellcome'));
        $breadcrumbs->addItem('Хлеб');
        return $this->render('AppFrontEndBundle:Page:bread.html.twig');

    }

    public function multiAction(Request $request)
    {

        $user=$this->getUser();

        dump($user->getStatus());
        $photo=$user->getPhoto();
        $status=$user->getStatus();
        if($status=="seller")
        {
            return $this->render('AppFrontEndBundle:Page:seller.html.twig', array('user'=>$user));
        }
        foreach($photo as $key=>$value)
        {
            $keys[]=$value->getId();
        }
        if(!isset($keys))
        {
            return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('user'=>$user));
        }
        if(is_null($photo))
        {
            return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('user'=>$user));
        }

        $orders=$this->prepareDate($keys);
        if(is_null($orders))
        {
            return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('photo' =>$photo,'user'=>$user));
        }
        //dump($orders);





        return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('photo' =>$photo,'user'=>$user,'orders'=>$orders));
    }


    public function prepareDate($keys)
    {
        $em=$this->getDoctrine()->getManager();
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

    //поиск
    public function searchAction(Request $request)
    {

        $login = $request->get("login");
       // dump($login);
        $status ="foto";
        if(is_null($login))
        {
            return $this->render('AppFrontEndBundle:Page:search.html.twig');
        }
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Users");
        $users=$repo->findBy(array('login' => $login, 'status' => $status));


        //$this->getDoctrine()->getRepository("");
       // dump($t);
       // return $this->redirectToRoute("app_front_end_wellcome");
        return $this->render('AppFrontEndBundle:Page:search.html.twig', array('users'=>$users));
    }

    //поиск
    public function catalogAction()
    {

        $status ="photo";
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:User2");
        $users=$repo->findBy(array('status' => $status));
        if(!is_null($this->getUser()))
        {
            $curUser = $this->getUser();
            return $this->render('AppFrontEndBundle:Page:catalog.html.twig', array('users'=>$users,'curUser'=>$curUser ));
        }
        //dump($users);
        //$this->getDoctrine()->getRepository("");


        // return $this->redirectToRoute("app_front_end_wellcome");
        return $this->render('AppFrontEndBundle:Page:catalog.html.twig', array('users'=>$users ));
    }

    // страничка фотографа
    public function photographAction($id)
    {


        //$this->getDoctrine()->getRepository("");

         $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:User2");
        $user=$repo->findOneById(array('id' => $id));
        $photo=$user->getPhoto();
        if(is_null($photo))
        {
            return $this->render('AppFrontEndBundle:Page:photopage.html.twig');
        }
        // return $this->redirectToRoute("app_front_end_wellcome");
        return $this->render('AppFrontEndBundle:Page:photopage.html.twig', array('user'=>$user,'photo'=>$photo ));
    }


    //страница заказа

    public function orderAction($id)
    {

        /*$us=$this->get('app_front_end_service')->showUser();
        dump($us);*/
      // $us= $this->get('app_front_end.check_files');


        $request=$this->getRequest();
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Photo");
        $photo = $repo->findOneById(array('id' => $id));

        $userrepo=$em->getRepository("BundlesStoreBundle:User2");
        $userrepo->findAll();

        $user=$photo->getUser2();


        return $this->render('AppFrontEndBundle:Page:order.html.twig', array('user'=>$user,'photo'=>$photo ));

    }

    //письмо
    public function getOrderAction()
    {
        $request = $this->getRequest();

        if(is_null($this->getUser()))
        {
            return $this->redirectToRoute("app_front_end_wellcome");
        }
        $id =$request->get('photo');
        $str = "I want yoo picture  ".$this->generateUrl('app_front_end_order',array('id' => $id),true);
         $message = \Swift_Message::newInstance()
             ->setSubject('Order')
             ->setFrom($this->getUser()->getEmail())
             ->setTo($request->get('user'))
             ->setBody($str) ;
         $this->get('mailer')->send($message);



         $em=$this->getDoctrine()->getManager();
         $order= new Orders();
         // dump($this->getUser());
         $order->setStatus("panding");
         $order->setUser2($this->getUser());

         $repo=$em->getRepository("BundlesStoreBundle:Photo");
         $photo = $repo->findOneById(array('id' => $id));
         // dump($photo);
         $order->setPhoto($photo);
         $em->persist($order);
          $em->flush();

      return $this->redirectToRoute("app_front_end_wellcome");

    }

    // подтверждение заказа
    //TODO сделать через один запрос или транзакцию
    public function approveOrderAction(Request $request)
    {

        $statArray = $request->get("checkbox");
        $em=$this->getDoctrine()->getManager();
        foreach($statArray as $key => $value)
        {
            $repo=$em->getRepository("BundlesStoreBundle:Orders");
            $order=$repo->findOneById($value);
            $order->setStatus($request->get("button"));
            $em->flush();
        }
        return $this->redirectToRoute("app_front_end_multi");

    }

}
