<?php

namespace App\FrontEndBundle\Controller;



use Bundles\StoreBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ImageController extends Controller
{

    //saving image
    public function saveAction(Request $request)
    {
        $files=$request->files->get("file");
        $em = $this->getDoctrine()
            ->getManager();
        foreach ($files as $key=>$file)
        {
            if(!is_object($file))
            {
                return $this->redirectToRoute("app_front_end_multi");
            }
            $user=$this->getUser();
            if(is_null($user))
            {
                return $this->redirectToRoute("app_front_end_multi");
            }

            $datetime = date("Y-m-d");
            $basepath = "upload/foto/".$datetime."/";
            $filename = uniqid() . '.' . $file->guessExtension();
            $file->move($basepath, $filename);
            $filename = $basepath. $filename;
            $photo = new Photo();
            $photo->setAdress('/'.$filename);
            $photo->setUser2($user);
            $em->persist($photo);
        }
        $em->flush();
        return $this->redirectToRoute("app_front_end_multi");
    }

   // delete
    public function deleteAction(Request $request)
    {
        $id=$request->get('id');
        //dump($id);

        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );

        $em=$this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:Photo");
        $ph = $repo->findOneById(array('id' => $id));
        $repo2 = $em->getRepository("BundlesStoreBundle:Orders");
        $orders = $repo2->findBy(array('photo'=>$ph));
        if(!$orders)
        {
            $em->remove($ph);
            $em->flush();
            return $this->redirectToRoute("app_front_end_multi");
        }
        foreach ($orders as $key=>$order)
        {
            $em->remove($order);
            $em->flush();
        }
        $em->remove($ph);
        $em->flush();
        return $this->redirectToRoute("app_front_end_multi");
    }

    // empty method
    public function editAction(Request $request)
    {

    }

    // action for fotosess
    public function fotoSessAction(Request $request)
    {
        $user=$this->getUser();
        $photo=$user->getPhoto();

        if(is_null($photo))
        {
            return $this->render('AppFrontEndBundle:Fotosess:fotosess.html.twig', array('user'=>$user));
            //return $this->render('AppFrontEndBundle:Page:fotosess.html.twig', array('user'=>$user));
        }
        foreach($photo as $key=>$value)
        {
            $keys[]=$value->getId();
        }
        if(!isset($keys))
        {
            return $this->render('AppFrontEndBundle:Fotosess:fotosess.html.twig', array('user'=>$user));
            //return $this->render('AppFrontEndBundle:Page:fotosess.html.twig', array('user'=>$user));
        }
        return $this->render('AppFrontEndBundle:Fotosess:fotosess.html.twig', array('photo' =>$photo,'user'=>$user));
        //return $this->render('AppFrontEndBundle:Page:fotosess.html.twig', array('photo' =>$photo,'user'=>$user));
    }

   //saving photo session
    public function saveFotoSessAction(Request $request)
    {
         $ok = $this->get('site_bundle.service')->justSavePhSess($request);
         if($ok =="Ok")
         {
             return $this->redirectToRoute("app_front_end_multi");
         }
        else
        {
            return $this->redirectToRoute("app_front_end_fotosess");
        }
    }

    //display propose photo session
    public function displayProposFsAction()
    {
        $galleries = $this->get('site_bundle.service')->getPropsFS();
        return $this->render('AppFrontEndBundle:Fotosess:prop.html.twig',array('galleries'=>$galleries));
    }

    // order photo session
    public function orderFsAction(Request $request)
    {
        if($request->get('button')=="delete")
        {
            $this->get('site_bundle.service')->delFS($request->get('galId'));
            return $this->redirectToRoute("app_front_end_dpfs");
        }
        if(!$request->get('images'))
        {
            return $this->redirectToRoute("app_front_end_dpfs");
        }
        else
        {
            $ok = $this->get('site_bundle.service')->saveOrders($request);
            return $this->redirectToRoute("app_front_end_dpfs");
        }
    }

   // order image
    public function orderAction (Request $request)
    {
        $id = $request->get('userId');

        if((!$request->get('images')) or (is_null($this->getUser())) )
        {
           return $this->redirectToRoute("app_front_end_photograph",array('id'=>$id));
        }
        else
        {
            $ok = $this->get('site_bundle.service')->saveOrders($request);
            return $this->redirectToRoute("app_front_end_photograph",array('id'=>$id));
        }
    }

    //save position watermark
    public function waterimgAction (Request $request)
    {
        $result = $this->get('site_bundle.service')->saveWaterPosition($request);
        if($result !='ERR')
        {
            $this->addFlash(
                'waterMessage',
                'Your watremark position saved!'
            );
        }
        return $this->redirectToRoute("app_front_end_profedit");
    }




}
