<?php

namespace Bundles\LoginBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Register extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname',null,array('required'=>true,'label'=>'Firstname'))
            ->add('lastname',null,array('required'=>true,'label'=>'Lastname'))
            ->add('email','email',array('required'=>true,'label'=>'Email','attr' => array('style' => 'width:200px')))
            ->add('username',null,array('required'=>true,'label'=>'Username'))
            ->add('password',null,array('required'=>true,'label'=>'Password'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => 'Bundles\StoreBundle\Entity\User2'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundles_storebundle_user2';
    }
}