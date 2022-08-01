<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/genre')]
class GenreController extends AbstractController
{
  #[Route('/index', name: 'genre_index')]
  public function genreIndex () {

  }

  #[Route('/detail/{id}', name: 'genre_detail' )]
  public function genreDetail ($id) {
    
  }
}
