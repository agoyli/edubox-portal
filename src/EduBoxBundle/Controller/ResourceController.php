<?php


namespace EduBoxBundle\Controller;


use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\Resource;
use EduBoxBundle\Entity\User;
use EduBoxBundle\Form\Type\CodeSubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResourceController extends Controller
{
    /**
     * @Route(path="/resource/list", name="edubox_resource_list")
     */
    public function listAction(Request $request)
    {
        $resources = $this
            ->getDoctrine()
            ->getRepository('EduBoxBundle:Resource')
            ->createQueryBuilder('r');

        $categoryId = (int)$request->get('category');
        $tagId = (int)$request->get('tag');
        $search = $request->get('search');

        if ($categoryId > 0) {
            $resources->leftJoin('r.categories', 'c')
                ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId);
        }

        if ($tagId > 0) {
            $resources->leftJoin('r.tags', 't')
                ->where('t.id = :tagId')->setParameter('tagId', $tagId);
        }

        if (strlen($search) > 0) {
            $resources
                ->andWhere(
                    $resources->expr()->like(
                        'CONCAT(lower(r.name),lower(r.content))',
                        $resources->expr()->literal('%'.$search.'%')
                    )
                );
        } else {
            $search = null;
        }

        $categories = $this->getDoctrine()->getRepository('ApplicationSonataClassificationBundle:Category')->findBy(['context' => 'resources']);
        $tags = $this->getDoctrine()->getRepository('ApplicationSonataClassificationBundle:Tag')->findBy(['context' => 'resources']);
        $resources = $resources->getQuery()->getResult();
        return $this->render('@EduBox/Front/resource/list.html.twig', [
            'resources' => $resources,
            'categories' =>  $categories,
            'tags' =>  $tags,
            'categoryId' => $categoryId,
            'tagId' => $tagId,
            'search' => $search,
        ]);

    }

    /**
     * @param Resource $resource
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/resource/{id}/show", name="edubox_resource_show")
     */
    public function showAction(Resource $resource)
    {
        return $this->render('@EduBox/Front/resource/show.html.twig', [
            'resource' => $resource,
        ]);
    }

}