<?php

namespace App\FrontEndBundle\Controller;



use Bundles\StoreBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ImageController extends Controller
{

    //сохранение картинки
    public function saveAction(Request $request)
    {
        $file=$request->files->get("file");
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

        $em = $this->getDoctrine()
            ->getManager();

        $file->move($basepath, $filename);
        $filename = $basepath. $filename;

        $photo = new Photo();
        $photo->setAdress('/'.$filename);
        $photo->setUser2($user);

        $em->persist($photo);
        $em->flush();
        return $this->redirectToRoute("app_front_end_multi");
    }


   // удаление
    public function deleteAction(Request $request)
    {
        $id=$request->get('id');
        //dump($id);
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


    public function editAction(Request $request)
    {

    }




}
