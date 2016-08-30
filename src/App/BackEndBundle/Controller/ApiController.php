<?php

namespace App\BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    public function testAction(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
       /* $res = 'Привет';
        $ar = array("word" => "Привет");
        header('Content-Type: text/html; charset=utf-8');
        $en = json_encode($ar, JSON_UNESCAPED_UNICODE);


        return new Response($en);
        return new JsonResponse($en);*/

        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository("BundlesStoreBundle:User2");
        $user = $repo->getUsid($id);
        if(!$user)
        {
            return new JsonResponse(['error'=>'Fail User']);
        }
       // dump($user);
       // exit;
        //$name = "vasia";
       return new JsonResponse($user[0]);
       // return new JsonResponse($name);
    }
}
