<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'add_to_cart')]
    public function addToCart (Request $request) {
       $id = $request->get('id');
       $book = $this->getDoctrine()->getRepository(Book::class)->find($id);
       $quantity = $request->get('quantity');
       $date = date('Y/m/d'); //get current date
       return $this->render('cart/detail.html.twig',
       [
          'book' => $book,
          'quantity' => $quantity,
          'date' => $date
       ]);
    }

    #[Route('/test', name : 'test')]
    public function test() {
        return $this->render('cart/test.html.twig');
    }
}
