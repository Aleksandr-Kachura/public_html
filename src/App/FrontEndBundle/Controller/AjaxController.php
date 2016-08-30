<?php

namespace App\FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller
{

   public function saveStatusAction(Request $request)
   {
       $id = $request->get('id');
       $access =$request->get('access');

       $em = $this->getDoctrine()->getManager();
       $repo=$em->getRepository("BundlesStoreBundle:Photo");
       $ph=$repo->findOneById($id);
       $ph->setAccess($access);
       $em->flush();
       return new JsonResponse(['status'=>"ok"]);

   }

   public function getFirstnamesAction(Request $request)
   {
       $firstname = $request->get('firstname');
       $em = $this->getDoctrine()->getManager();
       $repo=$em->getRepository("BundlesStoreBundle:User2");
       $firstnames = $repo->findFirstnames($firstname);
      // var_dump($firstnames);
       return new JsonResponse(['firstnames'=>$firstnames]);
   }


    public function checkUserAction(Request $request)
    {
        $email = $request->get('email');

        $em = $this->getDoctrine()->getManager();
        $repo=$em->getRepository("BundlesStoreBundle:User2");
        $ph=$repo->findOneByEmail($email);
        if(!$ph)
        {
            return new JsonResponse(['status'=>"ok"]);
        }
        else
        {
            return new JsonResponse(['message'=>"User с таким email-ом есть!!!"]);
        }
    }

}
