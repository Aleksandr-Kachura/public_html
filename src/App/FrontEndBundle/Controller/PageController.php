<?php

namespace App\FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Bundles\LoginBundle\Form\Type\Register;

//use Bundles\StoreBundle\Entity\Users;
use Bundles\StoreBundle\Entity\User2;
use Bundles\StoreBundle\Entity\Orders;
use Bundles\StoreBundle\Entity\Photo;
class PageController extends Controller
{
   //Главная
    public function indexAction()
    {
        $user=$this->getUser();
        if(is_null($user))
        {
            return $this->render('AppFrontEndBundle:Page:index.html.twig');
        }
        return $this->render('AppFrontEndBundle:Page:index.html.twig',array('user'=>$user));
    }


    //пагинация
    public function paginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $repo =$em->getRepository("BundlesStoreBundle:Page");
        $query =$repo->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );
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


    //профиль покупателя
    public function sellerAction(Request $request)
    {
        $id=$request->get("id");
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:User2");
        $user = $repo->findOneById(array('id' => $id));
        return $this->render('AppFrontEndBundle:Page:seller.html.twig', array('user'=>$user));
    }


    //профиль фотографа и покупателя
    public function multiAction(Request $request)
    {
        $user=$this->getUser();
        $photo=$user->getPhoto();
        $status=$user->getStatus();

        if($status=="seller")
        {
            return $this->render('AppFrontEndBundle:Page:seller.html.twig', array('user'=>$user));
        }
        if(is_null($photo))
        {
            return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('user'=>$user));
        }
        foreach($photo as $key=>$value)
        {
            $keys[]=$value->getId();
        }
        if(!isset($keys))
        {
            return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('user'=>$user));
        }

        $orders=$this->get('site_bundle.service')->prepareDate($keys);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $photo,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );

        if(is_null($orders))
        {

            return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('photo' =>$photo,'user'=>$user));
        }
        return $this->render('AppFrontEndBundle:Page:multi.html.twig', array('photo' =>$photo,'user'=>$user,'orders'=>$orders,'pagination' => $pagination));
    }





    //поиск
    public function searchAction(Request $request)
    {

        $login = $request->get("login");

        if(empty($login))
        {
            return $this->render('AppFrontEndBundle:Page:search.html.twig');
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository("BundlesStoreBundle:User2");
        $users = $repo->findLog($login);
        return $this->render('AppFrontEndBundle:Page:search.html.twig', array('users'=>$users));


    }

    //католог фотографов
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

        return $this->render('AppFrontEndBundle:Page:catalog.html.twig', array('users'=>$users ));
    }

    // страничка фотографа
    public function photographAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:User2");
        $user=$repo->findOneById(array('id' => $id));
        $photo=$user->getPhoto();
        if(is_null($photo))
        {
            return $this->render('AppFrontEndBundle:Page:photopage.html.twig');
        }
        return $this->render('AppFrontEndBundle:Page:photopage.html.twig', array('user'=>$user,'photo'=>$photo ));
    }


    //страница заказа

    public function orderAction($id)
    {
        $request=$this->getRequest();
        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Photo");
        $photo = $repo->findOneById(array('id' => $id));
        $this->get('site_bundle.service')->init();
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
        $order->setStatus("panding");
        $order->setUser2($this->getUser());

        $repo=$em->getRepository("BundlesStoreBundle:Photo");
        $photo = $repo->findOneById(array('id' => $id));

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
        if(!$statArray)
        {
            return $this->redirectToRoute("app_front_end_multi");
        }
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

    public function linkReturnAction()
    {
        $user_id=$this->getUser()->getId();
        $link= $this->get('site_bundle.service')->getlink($user_id);
        return new Response($link);
    }


    public function addUserAction(Request $request)
    {
        if($request->get('message'))
        {
           $param['message'] = $request->get('message');
           return $this->render('AppFrontEndBundle:Form:register.html.twig',$param);
        }
        $user=new User2();
        $form=$this->createForm(new Register(),$user);
        $param = array();


        if ($request->isMethod('POST'))
        {

            $form->submit($request);
           // dump($form->getData()->getUsername());
            if ($form->isValid())
            {
                $param['status'] = 'seller';
                $e=$this->get("site_bundle.helper")->create($form,$param);
                if($e)
                {

                    $param['form'] = $form->createView();
                    $param['error'] = $e;
                    return $this->render('AppFrontEndBundle:Form:register.html.twig',$param);
                    // return $this->render('BundlesLoginBundle:Login:register.html.twig',array('form'=>$form->createView(),'error'=>$e));
                }
                $str="User ".$this->getUser()->getEmail()." created your profile http://mvp.intechsoft.net/login  Where Login :".$form->getData()->getUsername()."
                Password :".$form->getData()->getPassword();
                $message = \Swift_Message::newInstance()
                    ->setSubject('Hello Email')
                    ->setFrom('send@example.com')
                  ///  ->setTo('akachura.its@gmail.com')
                    ->setTo($form->getData()->getEmail())
                    ->setBody($str)

                ;

                $this->get('mailer')->send($message);
                return $this->redirectToRoute("app_front_end_addus",array('message' => "User created"));
            }

        }


        $param['form'] = $form->createView();
        return $this->render('AppFrontEndBundle:Form:register.html.twig',$param);
    }



}
