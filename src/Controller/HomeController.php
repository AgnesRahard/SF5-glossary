<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * url par défaut
     * @Route("/", 
     * name="home_page")
     * @return void
     */
    function indexAction()
    {
        return $this->redirectToRoute('hello_page');
    }

    /**
     * @Route("/home/{name}", 
     * name="hello_page",
     * defaults={"name":""}
     * )
     */
    public function helloAction($name = "")
    {
        // return new Response('Hello world');
        return $this->render('home\index.html.twig', ['name' => $name]);
    }
}
