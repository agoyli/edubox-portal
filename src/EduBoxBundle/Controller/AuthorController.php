<?php


namespace EduBoxBundle\Controller;


use EduBoxBundle\Entity\Author;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/author/list", name="edubox_author_list")
     */
    public function listAction(Request $request)
    {
        $authorManager = $this->get('edubox_author_manager');
        return $this->render('@EduBox/Front/author/list.html.twig', [
            'authors' => $authorManager->getAuthorsBy($request),
            'categories' =>  $authorManager->getCategories(),
        ]);
    }

    /**
     * @param Author $author
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/author/{id}/show", name="edubox_author_show")
     */
    public function showAction(Author $author)
    {
        return $this->render('@EduBox/Front/author/show.html.twig', [
            'author' => $author,
        ]);
    }

}