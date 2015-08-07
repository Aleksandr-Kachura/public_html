<?php

namespace Bundles\LoginBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\SecurityContext;
use Bundles\LoginBundle\Form\Type\Register;
use Bundles\StoreBundle\Entity\User2;

class LoginController extends Controller
{
    //регистрация
    public function regAction(Request $request)
    {
        $user=new User2();
        $form=$this->createForm(new Register(),$user);
        $newUser=$this->get('request')->request->get('user');

       // dump($form->get('username')->getData());
       if ($request->isMethod('POST')) {
            $form->submit($request);

            if ($form->isValid()) {
                // perform some action...
                $status = $request->get('status');
                $this->create($form,$status);

                return $this->redirect($this->generateUrl('bundles_login_create1',array('form'=>$form)));
            }
        }
        return $this->render('BundlesLoginBundle:Login:register.html.twig',array('form'=>$form->createView()));
    }


    //сохранение
    public function create($form,$status)
    {
        $member = new User2();

        $checkLogin = $this->getDoctrine()->getManager()->getRepository('Bundles\StoreBundle\Entity\User2')->findOneBy(array('username' => $form->get('username')->getData()));
        if(isset($checkLogin)){
            // собщение для пользователя
            $_SESSION['message'] = 'Such login already exists';
            $_SESSION['active'] = true;
            return $this->redirect($this->generateUrl( 'homepage' ));
        }

        $em = $this->getDoctrine()->getEntityManager();
        $email = $form->get('email')->getData();

        // создание пользователя
        $member
            ->setEmail($email)
            ->setUsername($form->get('username')->getData())
            ->setFirstname( $form->get('firstname')->getData())
            ->setLastname( $form->get('lastname')->getData())
            ->setSalt(md5(time()))
            ->setStatus($status);

        // шифрует и устанавливает пароль для пользователя,
        // эти настройки совпадают с конфигурационными файлами
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);

        $password = $encoder->encodePassword($form->get('password')->getData(), $member->getSalt());
        $member->setPassword($password);

        //$member->getUserRoles()->add($role);

        $em->persist($member);
        $em->flush();
    }


    public function formLoginAction()
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        dump($error);
        return $this->render('BundlesLoginBundle:Login:loginpage.html.twig', array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }

    public function createAction(Request $request)
    {
        $form=$request->get('form');
        dump($form);
        $em=$this->getDoctrine()->getEntityManager();
        $use=$em->getRepository('EnvBrazilLoginBundle:Users');
        $users=$use->findByUsername($newUser['username']);
        $mail=$use->findByEmail($newUser['email']);
        $check=explode('@',$newUser['email']);

        $user=new User2();
        $form=$this->createForm(new Register(),$user);
        if($form->isValid()){
            return $this->redirect($this->generateUrl('bundles_login_create'));
        }
        return $this->render('BundlesLoginBundle:Login:register.html.twig',array('form'=>$form->createView()));
    }



}
