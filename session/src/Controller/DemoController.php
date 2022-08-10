<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemoController extends AbstractController
{
    public function __construct()
    {
        $this->session = new Session();
    }
    #[Route('/web1', name: 'web1')]
    public function web1(){
        $greenwich = "Greenwich University";
        $this->session->set('fpt',$greenwich);
        $this->session->set('vn', "Vietnam is a peaceful country");
        return $this->render('demo/web1.html.twig');
    }

    #[Route("/web2", name: 'web2')]
    public function web2() {
        $vn = $this->session->get('vn');
        return $this->render('demo/web2.html.twig');
    }
}
