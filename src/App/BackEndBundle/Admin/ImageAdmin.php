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

class ImageAdmin extends Admin
{
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', 'file', array('required' => false))

            //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('filename')

            //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('filename')

            //if no type is specified, SonataAdminBundle tries to guess it
        ;
    }


    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('filename');
    }


    public function prePersist($image) {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image) {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image) {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }
}