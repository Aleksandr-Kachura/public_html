<?php

namespace App\BackEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    public function testAction()
    {
        header("Access-Control-Allow-Origin: *");
        $name = "vasia";
        //$name = json_encode(['firstname'=>$name ]);
        return new JsonResponse(['firstname'=>$name ]);
       // return new JsonResponse($name);
    }
}
