<?php


namespace EduBoxBundle\Admin;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\ClassificationBundle\Entity\Tag;
use Doctrine\ORM\EntityRepository;
use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Form\Type\ExamplesJsonType;
use FOS\CKEditorBundle\DependencyInjection\Configuration;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\Form\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProblemAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'edubox_admin_problem';
    protected $baseRoutePattern = 'problem';

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
            ->add('name')
            ->add('categories', EntityType::class, [
                'multiple' => true,
                'class' => Category::class,
                'query_builder' => function(EntityRepository $manager) {
                    $qb = $manager->createQueryBuilder('q');
                    $qb->where('q.context = :context')->setParameter('context', Problem::$context);
                    return $qb;
                }
            ])
            ->add('tags', EntityType::class, [
                'multiple' => true,
                'class' => Tag::class,
                'query_builder' => function(EntityRepository $manager) {
                    $qb = $manager->createQueryBuilder('q');
                    $qb->where('q.context = :context')->setParameter('context', Problem::$context);
                    return $qb;
                }
            ])
            ->add('description', CKEditorType::class, [
                'config' => array('toolbar' => 'standard'),
            ])
            ->add('tests', CollectionType::class, [], [
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => ['problem_id' => $this->getSubject()->getId()],
            ])
            ->add('codes', CollectionType::class, [], [
                'edit' => 'inline',
                'inline' => 'table',
                'link_parameters' => ['problem_id' => $this->getSubject()->getId()],
            ]);
    }

}