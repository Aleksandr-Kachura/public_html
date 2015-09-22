<?php
namespace Bundles\LoginBundle\Service;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 17.06.15
 * Time: 8:43
 */
use Bundles\StoreBundle\Entity\User2;
use Bundles\StoreBundle\Entity\Stat;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

class Helper
{

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function showAct()
    {
        $doctrine = $this->container->get('doctrine')->getManager();
        $req=$this->container->get('request');
         return ("111");
    }

    //сохранени е
    public function create($form,$param)
    {
       $error=null;
       // $member = new User2();
        $member =  new User2();
        $em = $this->container->get('doctrine')->getManager();
        $repo = $em->getRepository('Bundles\StoreBundle\Entity\User2');
        $checkLogin =  $repo->findOneBy(array('username' => $form->get('username')->getData()));


        if(isset($param['ref']))
        {
            $refferal = $repo ->findOneBy(array('referralCode'=>$param['ref']));
            if (!$refferal)
            {
                $error = 'Not correct ref code.Please dont input this field or input correct data';
                return $error;
            }
        }

      if(isset($checkLogin))
        {
            $error = 'Уже существует такой пользователь';
            return $error;
        }

        if(strlen($form->get('password')->getData())<6)
        {
            $error = 'Не слишком короткий пароль мин 6 символов';
            return $error;
        }

        if(!preg_match("/^([a-zA-Zа-яА-Я]]+|[^0-9]+)$/i",$form->get('firstname')->getData()))
        {

            $error = 'Можно вводить только числа и только слова';
            return $error;
        }


        $email = $form->get('email')->getData();

        // создание пользователя
        $member
            ->setEmail($email)
            ->setUsername(trim($form->get('username')->getData()))
            ->setFirstname(trim($form->get('firstname')->getData()))
            ->setLastname( trim($form->get('lastname')->getData()))
            ->setSalt(md5(time()))
            ->setStatus($param['status']);

        // шифрует и устанавливает пароль для пользователя,
        // эти настройки совпадают с конфигурационными файлами
        $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);

        $password = $encoder->encodePassword($form->get('password')->getData(), $member->getSalt());
        $member->setPassword($password);




        $em->persist($member);

        if(isset($refferal))
        {
            $ref = new Stat();
            $ref->setRefId($refferal->getId());
            $ref->setUser2($member);
            $em->persist($ref);
        }

        $em->flush();
    }
}