<?php

namespace Bundles\LoginBundle\Controller;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Security\Core\SecurityContext;
use Bundles\LoginBundle\Form\Type\Register;
use Bundles\StoreBundle\Entity\User2;
use Symfony\Component\HttpFoundation\JsonResponse;


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

                //return $this->redirect($this->generateUrl('bundles_login_create1',array('form'=>$form)));
                return $this->redirectToRoute("bundles_login_form");
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


    // вывод формы в логине
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


    // какая то  шняга, но убрать жалко
    public function createAction(Request $request)
    {
        session_start();
        $form=$request->get('form');
        //dump($form);
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


    public function fbUserInfoAction(Request $request)
    {

        $fb = new Facebook([
            'app_id' => '1475718472749501',
            'app_secret' => 'a67fee083c27186f52030ff3a72f24f9',
            'default_graph_version' => 'v2.4',
            //'default_access_token' => '{access-token}', // optional
        ]);


        try {
            // Get the Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            //$response = $fb->get('/me', '{access-token}');
            $helper = $fb->getJavaScriptHelper();
            $accessToken = $helper->getAccessToken();

            $fb->setDefaultAccessToken((string) $accessToken);

            $response = $fb->get('/me?locale=en_US&fields=name,email');
            $userNode = $response->getGraphUser();
           // dump($userNode->getField('email'));
            $email = $userNode->getField('email');
            dump($userNode->getField('name'));
            $name =$userNode->getField('name');
            $arr = explode("@",$email);
            $login =$arr[0];
            $arr2 = explode(" ",$name);
            $firstname = $arr2[0];
            $lastname = $arr2[1];
            /*dump($firstname);
            dump($lastname);
            dump($login);*/
            return new JsonResponse(['firstname'=>$firstname,'lastname'=>$lastname,'login'=> $login,'email'=> $email ]);
            /* dump($userNode->getField('email'));
            dump( $userNode['email']);*/



        } catch(FacebookResponseException  $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }


        exit;
    }



}
