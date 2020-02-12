<?php


namespace EduBoxBundle\Admin;


use Application\Sonata\ClassificationBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;
use EduBoxBundle\Entity\Author;
use EduBoxBundle\Entity\Book;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookAdmin extends AbstractAdmin
{
    protected $baseRouteName = 'edubox_admin_book';
    protected $baseRoutePattern = 'book';

    protected function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('name');
        $list->add('pages');
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
                    $qb->where('q.context = :context')->setParameter('context', 'book');
                return $qb;
                }
            ], [
                'link_parameters' => [
                    'context' => 'book',
                ],
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'multiple' => true,
                'required' => false,
            ])
            ->add('year')
            ->add('pageCount')
            ->add('description', CKEditorType::class, [
                'config' => array('toolbar' => 'basic'),
            ])
            ->add('bookFile', 'sonata_type_model_list', [], [
                'link_parameters' => [
                    'context' => 'book',
                    'filter[contentType][value]' => 'pdf',
                ]
            ])
            ->add('bookImage', 'sonata_type_model_list', [], [
                'link_parameters' => [
                    'context' => 'book',
                    'filter[contentType][value]' => 'image',
                ]
            ])
            ->add('part')
            ->add('parts', EntityType::class, [
                'class' => Book::class,
                'multiple' => true,
                'required' => false,
            ])
            ->add('edition')
            ->add('editions', EntityType::class, [
                'class' => Book::class,
                'multiple' => true,
                'required' => false,
            ]);
    }
}