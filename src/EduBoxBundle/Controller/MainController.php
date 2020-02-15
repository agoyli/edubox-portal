<?php

namespace EduBoxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function homeAction()
    {
        return $this->render('@EduBox/Front/homepage.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/contact", name="edubox_contact")
     */
    public function contactAction()
    {
        return $this->render('@EduBox/Front/contact.html.twig');
    }
}
