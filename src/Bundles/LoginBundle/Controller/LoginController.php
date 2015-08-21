<?php

namespace Bundles\LoginBundle\Controller;

use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Facebook\Facebook;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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


       if ($request->isMethod('POST')) {
            $form->submit($request);
           //dump()
            if ($form->isValid()) {

                // perform some action...


                $status = $request->get('status');
                $e=$this->get("site_bundle.helper")->create($form,$status);
                if($e)
                {
                    return $this->render('BundlesLoginBundle:Login:register.html.twig',array('form'=>$form->createView(),'error'=>$e));
                }
                //$this->create($form,$status);

                //return $this->redirect($this->generateUrl('bundles_login_create1',array('form'=>$form)));
                return $this->redirectToRoute("bundles_login_form");
            }
        }
        return $this->render('BundlesLoginBundle:Login:register.html.twig',array('form'=>$form->createView()));
    }

    // вывод формы в логине
    public function formLoginAction()
    {
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        //dump($error);
        return $this->render('BundlesLoginBundle:Login:loginpage.html.twig', array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }


    // вставка фб
    public function fbUserInfoAction(Request $request)
    {

        $fb = new Facebook([
            'app_id' => '1475718472749501',
            'app_secret' => 'a67fee083c27186f52030ff3a72f24f9',
            'default_graph_version' => 'v2.4',
            //'default_access_token' => '{access-token}', // optional
        ]);


        try {
            $helper = $fb->getJavaScriptHelper();
            $accessToken = $helper->getAccessToken();

            $fb->setDefaultAccessToken((string) $accessToken);

            $response = $fb->get('/me?locale=en_US&fields=name,email');
            $userNode = $response->getGraphUser();
            $email = $userNode->getField('email');
            $name =$userNode->getField('name');
            $arr = explode("@",$email);
            $login =$arr[0];
            $arr2 = explode(" ",$name);
            $firstname = $arr2[0];
            $lastname = $arr2[1];
            return new JsonResponse(['firstname'=>$firstname,'lastname'=>$lastname,'login'=> $login,'email'=> $email ]);
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
