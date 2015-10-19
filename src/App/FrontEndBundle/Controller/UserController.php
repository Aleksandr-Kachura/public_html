<?php

namespace App\FrontEndBundle\Controller;



use App\FrontEndBundle\Form\Type\EditProfile;
use Bundles\StoreBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $entity=$this->getUser();
        $form=$this->createForm(new EditProfile(),$entity);
        if ($request->isMethod('POST'))
        {
            $form->submit($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                if($form['extra']->getData())
                {
                    $imagesPath = "upload/IMG/".$entity->getId();
                    $file = $form['extra']->getData();
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();

                    $path=   $imagesPath."/".$fileName;
                    $file->move($imagesPath, $fileName);

                    $entity->setImg($path);
                }
                $em->persist($entity);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Your changes were saved!'
                );
                return $this->redirectToRoute("app_front_end_profedit");
            }
        }
        return $this->render('AppFrontEndBundle:User:index.html.twig',array('user'=>$entity,'form'=>$form->createView()));
    }

}
