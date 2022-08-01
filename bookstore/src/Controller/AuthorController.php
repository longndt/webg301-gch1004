<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/author')]
class AuthorController extends AbstractController
{
   #[Route('/index', name: 'author_index')]
   public function authorIndex () {
      $authors = $this->getDoctrine()->getRepository(Author::class)->findAll();
      return $this->render('author/index.html.twig',
        [
            'authors' => $authors
        ]);
   } 

   #[Route('/list', name: 'author_list')]
   public function authorList() {
      $authors = $this->getDoctrine()->getRepository(Author::class)->findAll();
      return $this->render('author/list.html.twig',
        [
            'authors' => $authors
        ]);
   } 

   #[Route('/detail/{id}', name: 'author_detail')]
   public function authorDetail ($id, AuthorRepository $authorRepository) {
      $author = $authorRepository->find($id);
      if ($author == null) {
         $this->addFlash('Warning','Invalid author id !');
         return $this->redirectToRoute('author_index');
      }
      return $this->render('author/detail.html.twig',
        [
            'author' => $author
        ]);   
   }

   #[Route('/delete/{id}', name: 'author_delete')]
   public function authorDelete ($id, ManagerRegistry $managerRegistry) {
     $author = $managerRegistry->getRepository(Author::class)->find($id);
     if ($author == null) {
        $this->addFlash('Warning', 'Author not existed !');
     } else {
        $manager = $managerRegistry->getManager();
        $manager->remove($author);
        $manager->flush();
        $this->addFlash('Info', 'Delete author succeed !');
     }
     return $this->redirectToRoute('author_index');
   }

   #[Route('/add', name: 'author_add')]
   public function authorAdd (Request $request) {

   }

   #[Route('/edit/{id}', name: 'author_edit')]
   public function authorEdit ($id, Request $request) {

   }
}
