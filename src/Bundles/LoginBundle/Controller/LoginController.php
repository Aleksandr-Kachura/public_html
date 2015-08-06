<?php

namespace Bundles\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\SecurityContext;

use Site\BackEndBundle\Entity\User2;

class LoginController extends Controller
{
    public function indexAction($name)
    {
       // return $this->render('BundlesLoginBundle:Default:index.html.twig', array('name' => $name));
       // dump("111");
    }
}
