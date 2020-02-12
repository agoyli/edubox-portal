<?php


namespace EduBoxBundle\Admin;


use EduBoxBundle\Entity\Author;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class AuthorAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'edubox_admin_author';
    protected $baseRoutePattern = 'author';

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('fullName');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('fullName', 'text');
    }
}