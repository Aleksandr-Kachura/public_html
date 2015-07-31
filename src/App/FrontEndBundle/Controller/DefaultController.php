<?php

namespace App\FrontEndBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AppFrontEndBundle:Default:index.html.twig', array('name' => $name));
    }
}
