<?php


namespace EduBoxBundle\DomainManager;


use Doctrine\ORM\EntityManager;
use EduBoxBundle\Entity\Author;
use Symfony\Component\HttpFoundation\Request;

class AuthorManager
{
    private $entityManager;

    /**
     * AuthorManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return \Application\Sonata\ClassificationBundle\Entity\Category[]|\Application\Sonata\ClassificationBundle\Entity\Tag[]|array
     */
    public function getCategories()
    {
        return $this
            ->entityManager
            ->getRepository('ApplicationSonataClassificationBundle:Category')
            ->findBy(['context' => Author::$context]);
    }

    public function getAuthorsBy(Request $request)
    {
        $authors = $this
            ->entityManager
            ->getRepository('EduBoxBundle:Author')
            ->createQueryBuilder('a');

        $categoryId = (int)$request->get('category');
        $search = $request->get('search');

        if ($categoryId > 0) {
            $authors->leftJoin('a.categories', 'c')
                ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId);
        }

        if (strlen($search) > 0) {
            $authors
                ->andWhere(
                    $authors->expr()->like(
                        'CONCAT(lower(a.content),lower(a.fullName))',
                        $authors->expr()->literal('%'.strtolower(trim($search)).'%')
                    )
                );
        }

        return $authors->getQuery();
    }

}