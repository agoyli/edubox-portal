<?php


namespace EduBoxBundle\Admin;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use EduBoxBundle\Entity\Resource;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ResourceAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'edubox_admin_resource';
    protected $baseRoutePattern = 'resource';

    protected function configureFormFields(FormMapper $form)
    {
        $form->add('name');
        $form->add('categories', EntityType::class, [
            'multiple' => true,
            'class' => Category::class,
            'query_builder' => function(EntityRepository $manager) {
                $qb = $manager->createQueryBuilder('q');
                $qb->where('q.context = :context')->setParameter('context', Resource::$context);
                return $qb;
            }
        ]);
        $form->add('tags', EntityType::class, [
            'multiple' => true,
            'class' => Tag::class,
            'query_builder' => function(EntityRepository $manager) {
                $qb = $manager->createQueryBuilder('q');
                $qb->where('q.context = :context')->setParameter('context', Resource::$context);
                return $qb;
            }
        ]);
        $form->add('content', CKEditorType::class, [
            'config' => array('toolbar' => 'standard'),
        ]);
    }

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name');
    }
}