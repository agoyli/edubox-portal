<?php


namespace EduBoxBundle\DomainManager;


use Doctrine\ORM\EntityManager;
use EduBoxBundle\Entity\Problem;
use Symfony\Component\HttpFoundation\Request;

class ProblemManager
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

    public function getProblemsBy(Request $request)
    {
        $problems = $this
            ->entityManager
            ->getRepository('EduBoxBundle:Problem')
            ->createQueryBuilder('p');

        $categoryId = (int)$request->get('category');
        $tagIds = is_array($request->get('tags')) ? $request->get('tags') : [];
        $search = $request->get('search');

        if ($categoryId > 0) {
            $problems->leftJoin('p.categories', 'c')
                ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId);
        }

        if (count($tagIds) > 0) {
            $problems->leftJoin('p.tags', 't')
                ->where($problems->expr()->in('t.id', $tagIds));
        }

        if (strlen($search) > 0) {
            $problems
                ->andWhere(
                    $problems->expr()->like('CONCAT(lower(p.name),lower(p.description))', $problems->expr()->literal('%'.$search.'%'))
                );
        }

        return $problems->getQuery()->getResult();
    }

    public function getCategories()
    {
        return $this
            ->entityManager
            ->getRepository('ApplicationSonataClassificationBundle:Category')
            ->findBy(['context' => Problem::$context]);
    }

    public function getTags()
    {
        return $this
            ->entityManager
            ->getRepository('ApplicationSonataClassificationBundle:Tag')
            ->findBy(['context' => Problem::$context]);
    }
}