<?php

namespace App\FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Bundles\StoreBundle\Entity\Users;
use Bundles\StoreBundle\Entity\Orders;
use Bundles\StoreBundle\Entity\Photo;
class PageController extends Controller
{
    public function indexAction()
    {
        $user=$this->getUser();
        dump($user->getId());
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
        $photo=$user->getPhoto();
        foreach($photo as $key=>$value)
        {
            $keys[]=$value->getId();
        }
        $orders=$this->prepareDate($keys);
        dump($orders);
        if(is_null($photo))
        {
            return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('user'=>$user));
        }


        return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('photo' =>$photo,'user'=>$user,'orders'=>$orders));
    }


    public function prepareDate($keys)
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Orders");
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
        return $this->render('AppFrontEndBundle:Page:search.html.twig', array('users'=>$users ));
    }

    //поиск
    public function catalogAction()
    {

        $status ="foto";
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Users");
        $users=$repo->findBy(array('status' => $status));

        //$this->getDoctrine()->getRepository("");


        // return $this->redirectToRoute("app_front_end_wellcome");
        return $this->render('AppFrontEndBundle:Page:catalog.html.twig', array('users'=>$users ));
    }

    // страничка фотографа
    public function photographAction($id)
    {


        //$this->getDoctrine()->getRepository("");

         $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Users");
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

        $userrepo=$em->getRepository("BundlesStoreBundle:Users");
        $userrepo->findAll();

        $user=$photo->getUsers();


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
         $order->setUsers($this->getUser());

         $repo=$em->getRepository("BundlesStoreBundle:Photo");
         $photo = $repo->findOneById(array('id' => $id));
         // dump($photo);
         $order->setPhoto($photo);
         $em->persist($order);
          $em->flush();

      return $this->redirectToRoute("app_front_end_wellcome");

    }

}
