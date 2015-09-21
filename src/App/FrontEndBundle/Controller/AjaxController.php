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


}
