<?php


namespace EduBoxBundle\Admin;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;
use EduBoxBundle\Entity\Author;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

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
        $form->add('birthday', DateType::class, [
            'required' => false,
            'widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker'],
        ]);
        $form->add('categories', EntityType::class, [
            'required' => false,
            'multiple' => true,
            'class' => Category::class,
            'query_builder' => function(EntityRepository $manager) {
                $qb = $manager->createQueryBuilder('q');
                $qb->where('q.context = :context')->setParameter('context', Author::$context);
                return $qb;
            }
        ]);
        $form->add('content', CKEditorType::class, [
            'required' => false,
            'config' => array('toolbar' => 'standard'),
        ]);
        $form->add('image','sonata_type_model_list', [], [
            'required' => false,
            'link_parameters' => [
                'context' => Author::$context,
                'filter[contentType][value]' => 'image',
            ]
        ]);
    }
}