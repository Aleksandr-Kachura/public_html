<?php

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 29.05.15
 * Time: 19:39
 */
namespace App\BackEndBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;


use Knp\Menu\ItemInterface as MenuItemInterface;

class UserAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('firstname')
            ->add('lastname')
            ->add('username')
            //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username');

            //if no type is specified, SonataAdminBundle tries to guess it
        ;

    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('firstname')
            ->add('lastname')
            ->add('username');

            //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }


    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('firstname')
            ->add('lastname')
            ->add('username');
    }

}