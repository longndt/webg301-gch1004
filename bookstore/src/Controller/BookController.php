<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/book')]
class BookController extends AbstractController
{
   #[Route('/index', name: 'book_index')]
   public function bookIndex () {
      $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
      return $this->render('book/index.html.twig',
        [
            'books' => $books
        ]);
   } 

   #[Route('/list', name: 'book_list')]
   public function bookList() {
      $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
      return $this->render('book/list.html.twig',
        [
            'books' => $books
        ]);
   } 

   #[Route('/detail/{id}', name: 'book_detail')]
   public function bookDetail ($id, BookRepository $bookRepository) {
      $book = $bookRepository->find($id);
      if ($book == null) {
         $this->addFlash('Warning','Invalid book id !');
         return $this->redirectToRoute('book_index');
      }
      return $this->render('book/detail.html.twig',
        [
            'book' => $book
        ]);   
   }

   #[Route('/delete/{id}', name: 'book_delete')]
   public function bookDelete ($id, ManagerRegistry $managerRegistry) {
     $book = $managerRegistry->getRepository(Book::class)->find($id);
     if ($book == null) {
        $this->addFlash('Warning', 'Book not existed !');
     } else {
        $manager = $managerRegistry->getManager();
        $manager->remove($book);
        $manager->flush();
        $this->addFlash('Info', 'Delete book succeed !');
     }
     return $this->redirectToRoute('book_index');
   }

   #[Route('/add', name: 'book_add')]
   public function bookAdd (Request $request) {
      $book = new Book;
      $form = $this->createForm(BookType::class,$book);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($book);
         $manager->flush();
         $this->addFlash('Info', 'Add book succeed !');
         return $this->redirectToRoute("book_index");
      }
      return $this->renderForm("book/add.html.twig",
      [
            'bookForm' => $form
      ]);
   }

   #[Route('/edit/{id}', name: 'book_edit')]
   public function bookEdit ($id, Request $request) {
        $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
        if ($book == null) {
            $this->addFlash('Warning', 'Book not existed !');
         } else {
            $form = $this->createForm(BookType::class,$book);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($book);
                $manager->flush();
                $this->addFlash('Info', 'Edit book succeed !');
                return $this->redirectToRoute("book_index");
            }
            return $this->renderForm("book/edit.html.twig",
            [
                'bookForm' => $form
            ]);
         }
   }

   #[Route('/cart', name: 'add_to_cart')]
   public function addToCart (Request $request) {
      $id = $request->get('id');
      $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
      $quantity = $request->get('quantity');
      $date = date('Y/m/d');
      return $this->render('book/cart.html.twig',
      [
         'book' => $book,
         'quantity' => $quantity,
         'date' => $date
      ]);
   }
}
