<?php

namespace App\FrontEndBundle\Controller;



use App\FrontEndBundle\Form\Type\EditProfile;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class UserController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $this->get('session');
        //$session->clear();
        $session->set('fr', array(
            'accounts' => 'value',
        ));



        $user=$this->getUser();
        $form=$this->createForm(new EditProfile(),$user);
        $em = $this->getDoctrine()->getManager();

        //TODO все в сервис
        $waterRepo = $em->getRepository("BundlesStoreBundle:WaterMark");
        $position = $waterRepo->findOneBy(array('user2' => $user));

        if(empty($position))
        {
            $user->config = 'center';
        }
        else
        {
            $user->config = $position->getPosition();
        }


        if ($request->isMethod('POST'))
        {
            $form->submit($request);

            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getManager();

                if($form['extra']->getData())
                {
                    $imagesPath = "upload/IMG/".$user->getId();
                    $file = $form['extra']->getData();
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $path=   $imagesPath."/".$fileName;
                    $file->move($imagesPath, $fileName);
                    $user->setImg($path);
                }
                $em->persist($user);
                $em->flush();
                $this->addFlash(
                    'notice',
                    'Your changes were saved!'
                );
                // In a controller


                return $this->redirectToRoute("app_front_end_profedit");
            }
        }
        return $this->render('AppFrontEndBundle:User:index.html.twig',array('user'=>$user,'form'=>$form->createView()));
    }

}
