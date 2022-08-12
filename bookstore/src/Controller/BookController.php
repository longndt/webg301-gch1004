<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use function PHPUnit\Framework\throwException;

#[Route('/book')]
class BookController extends AbstractController
{
   #[IsGranted("ROLE_ADMIN")]
   #[Route('/index', name: 'book_index')]
   public function bookIndex(BookRepository $bookRepository)
   {
      //$books = $this->getDoctrine()->getRepository(Book::class)->findAll();
      $books = $bookRepository->sortBookByIdDesc();
      return $this->render(
         'book/index.html.twig',
         [
            'books' => $books
         ]
      );
   }

   #[IsGranted("ROLE_CUSTOMER")]
   #[Route('/list', name: 'book_list')]
   public function bookList()
   {
      $books = $this->getDoctrine()->getRepository(Book::class)->findAll();
      return $this->render(
         'book/list.html.twig',
         [
            'books' => $books
         ]
      );
   }

   #[Route('/detail/{id}', name: 'book_detail')]
   public function bookDetail($id, BookRepository $bookRepository)
   {
      $book = $bookRepository->find($id);
      if ($book == null) {
         $this->addFlash('Warning', 'Invalid book id !');
         return $this->redirectToRoute('book_index');
      }
      return $this->render(
         'book/detail.html.twig',
         [
            'book' => $book
         ]
      );
   }

   #[Route('/delete/{id}', name: 'book_delete')]
   public function bookDelete($id, ManagerRegistry $managerRegistry)
   {
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
   public function bookAdd(Request $request)
   {
      $book = new Book;
      $form = $this->createForm(BookType::class, $book);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         //bổ sung code upload ảnh
         //B1: lấy ra ảnh vừa upload
         $img = $book->getImage();
         //B2: set tên mới cho ảnh => đảm bảo tên ảnh là duy nhất trong thư mục
         $imgName = uniqid(); //uniqid : tạo ra string duy nhất
         //B3: lấy ra đuôi (extension) của ảnh
         $imgExtension = $img->guessExtension();
         //B4: hoàn thiện tên mới cho ảnh (giữ đuôi cũ và thay tên mới)
         $imageName = $imgName . "." . $imgExtension;
         //VD: greenwich.jpg 
         //B5: di chuyển ảnh về thư mục chỉ định trong project
         try {
            $img->move(
               $this->getParameter('book_image'),
               $imageName
               //di chuyển file ảnh upload về thư mục cùng với tên mới
               //note: cầu hình parameter trong file services.yaml
            );
         } catch (FileException $e) {
            throwException($e);
         }
         //B6: set dữ liệu của image vào object book
         $book->setImage($imageName);
         //lưu dữ liệu của book vào DB
         $manager = $this->getDoctrine()->getManager();
         $manager->persist($book);
         $manager->flush();
         $this->addFlash('Info', 'Add book succeed !');
         return $this->redirectToRoute("book_index");
      }
      return $this->renderForm(
         "book/add.html.twig",
         [
            'bookForm' => $form
         ]
      );
   }

   #[Route('/edit/{id}', name: 'book_edit')]
   public function bookEdit($id, Request $request)
   {
      $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
      if ($book == null) {
         $this->addFlash('Warning', 'Book not existed !');
      } else {
         $form = $this->createForm(BookType::class, $book);
         $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid()) {
            //kiểm tra xem người dùng có muốn upload ảnh mới hay không
            //nếu có thì thực hiện code upload ảnh
            //nếu không thì bỏ qua
            $imageFile = $form['image']->getData();
            if ($imageFile != null) {
               $image = $book->getImage();
               $imgName = uniqid();
               $imgExtension = $image->guessExtension();
               $imageName = $imgName . "." . $imgExtension;
               try {
                  $image->move(
                     $this->getParameter('book_image'),
                     $imageName
                  );
               } catch (FileException $e) {
                  throwException($e);
               }
               $book->setImage($imageName);
            }
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($book);
            $manager->flush();
            $this->addFlash('Info', 'Edit book succeed !');
            return $this->redirectToRoute("book_index");
         }
         return $this->renderForm(
            "book/edit.html.twig",
            [
               'bookForm' => $form
            ]
         );
      }
   }

   #[IsGranted('ROLE_CUSTOMER')]
   #[Route('/price/asc', name: 'sort_book_price_ascending')]
   public function sortBookPriceAscending(BookRepository $bookRepository)
   {
      $books = $bookRepository->sortBookPriceAsc();
      return $this->render(
         'book/list.html.twig',
         [
            'books' => $books
         ]
      );
   }

   #[IsGranted('ROLE_CUSTOMER')]
   #[Route('/price/desc', name: 'sort_book_price_descending')]
   public function sortBookPriceDescending(BookRepository $bookRepository)
   {
      $books = $bookRepository->sortBookPriceDesc();
      return $this->render(
         'book/list.html.twig',
         [
            'books' => $books
         ]
      );
   }

   #[IsGranted('ROLE_CUSTOMER')]
   #[Route('/search', name: 'search_book_title')]
   public function searchBook(BookRepository $bookRepository, Request $request)
   {
      $key = $request->get('keyword');
      $books = $bookRepository->searchBookByTitle($key);
      //   if ($books == null) {
      //      $this->addFlash('Warning', "No book found");
      //   }
      return $this->render(
         'book/list.html.twig',
         [
            'books' => $books
         ]
      );
   }
}
