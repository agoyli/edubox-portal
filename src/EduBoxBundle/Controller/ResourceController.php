<?php


namespace EduBoxBundle\Controller;


use EduBoxBundle\Entity\Book;
use EduBoxBundle\Entity\Problem;
use EduBoxBundle\Entity\Resource;
use EduBoxBundle\Entity\User;
use EduBoxBundle\Form\Type\CodeSubmitType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ResourceController extends Controller
{
    /**
     * @Route(path="/resource/list", name="edubox_resource_list")
     */
    public function listAction(Request $request, PaginatorInterface $paginator)
    {
        $resourceManager = $this->get('edubox_resource_manager');
        return $this->render('@EduBox/Front/resource/list.html.twig', [
            'resources' => $paginator->paginate(
                $resourceManager->getResourcesBy($request),
                $request->query->getInt('page', 1),
                12
            ),
            'categories' =>  $resourceManager->getCategories(),
            'tags' =>  $resourceManager->getTags(),
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