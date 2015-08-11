<?php

namespace App\FrontEndBundle\Controller;

use Bundles\StoreBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ImageController extends Controller
{
   /*  public function indexAction()
    {
        return $this->render('AppFrontEndBundle:Page:index.html.twig');
    }*/

    //сохранение картинки
    public function saveAction(Request $request)
    {
        $file=$request->files->get("file");
       //  dump($file);
        $user=$this->getUser();
        dump($user);
        if(is_null($user))
        {
            return $this->redirectToRoute("app_front_end_multi");
        }

        $datetime = date("Y-m-d");
        $basepath = "upload/foto/".$datetime."/";
        $filename = uniqid() . '.' . $file->guessExtension();

        //  dump($file);
        //dump($this->getUser());
        $em = $this->getDoctrine()
            ->getManager();
        $file->move($basepath, $filename);
        $filename = $basepath. $filename;
        $photo = new Photo();
        $photo->setAdress('/'.$filename);
       // $photo->setUsers($user);
        $photo->setUser2($user);
        $em->persist($photo);
        $em->flush();




        return $this->redirectToRoute("app_front_end_multi");
    }




}
