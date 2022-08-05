<?php

namespace App\Controller;

use App\Entity\Genre;
use App\Form\GenreType;
use App\Repository\GenreRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/genre')]
class GenreController extends AbstractController
{
   public function __construct(ManagerRegistry $managerRegistry)
   {
      $this->managerRegistry = $managerRegistry;
   } 

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
   public function genreDelete ($id) {
     $genre = $this->managerRegistry->getRepository(Genre::class)->find($id);
     if ($genre == null) {
        $this->addFlash('Warning', 'Genre not existed !');
     } else if (count($genre->getBooks()) >= 1){ //check xem genre này có ràng buộc với book hay không trước khi xóa
         //nếu có tối thiểu 1 book thì hiển thị lỗi và không cho xóa  
      $this->addFlash('Warning', 'Can not delete this genre');
     }   
     else {
        $manager = $this->managerRegistry->getManager();
        $manager->remove($genre);
        $manager->flush();
        $this->addFlash('Info', 'Delete genre succeed !');
     }
     return $this->redirectToRoute('genre_index');
   }

   #[Route('/add', name: 'genre_add')]
   public function genreAdd (Request $request) {
      $genre = new Genre;
      $form = $this->createForm(GenreType::class,$genre);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->managerRegistry->getManager();
         $manager->persist($genre);
         $manager->flush();
         $this->addFlash('Info', 'Add genre succeed !');
         return $this->redirectToRoute("genre_index");
      }
      return $this->renderForm("genre/add.html.twig",
      [
            'genreForm' => $form
      ]);
   }

   #[Route('/edit/{id}', name: 'genre_edit')]
   public function genreEdit ($id, Request $request) {
        $genre = $this->managerRegistry->getRepository(Genre::class)->find($id);
        if ($genre == null) {
            $this->addFlash('Warning', 'Genre not existed !');
         } else {
            $form = $this->createForm(GenreType::class,$genre);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->managerRegistry->getManager();
                $manager->persist($genre);
                $manager->flush();
                $this->addFlash('Info', 'Edit genre succeed !');
                return $this->redirectToRoute("genre_index");
            }
            return $this->renderForm("genre/edit.html.twig",
            [
                'genreForm' => $form
            ]);
         }
   }
}
