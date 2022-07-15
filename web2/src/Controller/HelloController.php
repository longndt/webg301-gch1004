<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    //For PHP 8:
    #[Route('/hello', name : 'hello')]
    public function hello()
    {
        return $this->render('hello/hello.html.twig');
    }

    //For PHP 7:
    /**
     * @Route("/greenwich" , name = "greenwich")
     */
    public function greenwich() 
    {
        return $this->render('hello/greenwich.html.twig');
    }
}
