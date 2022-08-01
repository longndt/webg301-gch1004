<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/genre')]
class GenreController extends AbstractController
{
  #[Route('/index', name: 'genre_index')]
   public function genreIndex () {
      $genres = $this->getDoctrine()->getRepository(Genre::class)->findAll();
      return $this->render('genre/index.html.twig',
        [
            'genres' => $genres
        ]);
   } 

   #[Route('/list', name: 'genre_list')]
   public function genreList() {
      $genres = $this->getDoctrine()->getRepository(Genre::class)->findAll();
      return $this->render('genre/list.html.twig',
        [
            'genres' => $genres
        ]);
   } 

   #[Route('/detail/{id}', name: 'genre_detail')]
   public function genreDetail ($id, GenreRepository $genreRepository) {
      $genre = $genreRepository->find($id);
      if ($genre == null) {
         $this->addFlash('Warning','Invalid genre id !');
         return $this->redirectToRoute('genre_index');
      }
      return $this->render('genre/detail.html.twig',
        [
            'genre' => $genre
        ]);   
   }

   #[Route('/delete/{id}', name: 'genre_delete')]
   public function genreDelete ($id, ManagerRegistry $managerRegistry) {
     $genre = $managerRegistry->getRepository(Genre::class)->find($id);
     if ($genre == null) {
        $this->addFlash('Warning', 'Genre not existed !');
     } else {
        $manager = $managerRegistry->getManager();
        $manager->remove($genre);
        $manager->flush();
        $this->addFlash('Info', 'Delete genre succeed !');
     }
     return $this->redirectToRoute('genre_index');
   }

   #[Route('/add', name: 'genre_add')]
   public function genreAdd (Request $request) {

   }

   #[Route('/edit/{id}', name: 'genre_edit')]
   public function genreEdit ($id, Request $request) {

   }
}
