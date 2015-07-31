<?php

namespace Bundles\StoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BundlesStoreBundle:Default:index.html.twig', array('name' => $name));
    }
}
