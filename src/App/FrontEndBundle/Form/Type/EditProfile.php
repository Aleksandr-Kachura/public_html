<?php

namespace App\FrontEndBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EditProfile extends AbstractType
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
            ->add('email','email',array('required'=>true,'label'=>'Email'))
            ->add('username',null,array('required'=>true,'label'=>'Username'))
            ->add('city',null,array('required'=>true,'label'=>'City'))
            ->add('country',null,array('required'=>true,'label'=>'Country'))
            ->add('descTech','textarea',array('required'=>false,'label'=>'TechInfo'))
            ->add('image', 'file', array('required'=>false,'mapped' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolve
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