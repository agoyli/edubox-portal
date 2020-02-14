<?php


namespace EduBoxBundle\DomainManager;


use Doctrine\ORM\EntityManager;
use EduBoxBundle\Entity\Resource;
use Symfony\Component\HttpFoundation\Request;

class ResourceManager
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

    public function getResourcesBy(Request $request)
    {

        $resources = $this
            ->entityManager
            ->getRepository('EduBoxBundle:Resource')
            ->createQueryBuilder('r');

        $categoryId = (int)$request->get('category');
        $tagIds = is_array($request->get('tags')) ? $request->get('tags') : [];
        $search = $request->get('search');

        if ($categoryId > 0) {
            $resources->leftJoin('r.categories', 'c')
                ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId);
        }

        if (count($tagIds) > 0) {
            $resources->leftJoin('r.tags', 't')
                ->where($resources->expr()->in('t.id', $tagIds));
        }

        if (strlen($search) > 0) {
            $resources
                ->andWhere(
                    $resources->expr()->like(
                        'CONCAT(lower(r.name),lower(r.content))',
                        $resources->expr()->literal('%'.$search.'%')
                    )
                );
        }

        return $resources->getQuery()->getResult();
    }

    public function getCategories()
    {
        return $this
            ->entityManager
            ->getRepository('ApplicationSonataClassificationBundle:Category')
            ->findBy(['context' => Resource::$context]);
    }

    public function getTags()
    {
        return $this
            ->entityManager
            ->getRepository('ApplicationSonataClassificationBundle:Tag')
            ->findBy(['context' => Resource::$context]);
    }
}