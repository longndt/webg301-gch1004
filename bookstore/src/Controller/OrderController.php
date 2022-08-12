<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/cart/info', name: 'add_to_cart')]
    public function addToCart (Request $request) {
       //khởi tạo session
       $session = $request->getSession();
       //lấy dữ liệu gửi từ form Add To Cart
       $book = $this->getDoctrine()->getRepository(Book::class)->find($request->get('id'));
       $quantity = $request->get('quantity');
       //tạo biến date để lưu thông tin về ngày hiện tại
       $date = date('Y/m/d');  
       //tạo biến datetime để lưu thông tin về ngày giờ hiện tại
       $datetime = date('Y/m/d H:i:s');  
       //tạo biến user để lấy ra user hiện tại (đang login)
       $user = $this->getUser();
       //tạo biến totalprice để lưu tổng tiền của đơn hàng
       $bookprice = $book->getPrice();
       $totalprice = $bookprice * $quantity;
       //set biến session (global variable) để lưu dữ liệu 
       $session->set('book', $book);
       $session->set('user', $user);
       $session->set('quantity', $quantity);
       $session->set('totalprice', $totalprice);
       $session->set('datetime', $datetime);
       return $this->render('cart/detail.html.twig');
    }

    #[Route('/order/make', name: 'make_order')]
    public function orderMake() 
    {
        //khởi tạo session;
        $session = new Session();
        //tạo object Order

        //set các thuộc tính cho object Order

        //lưu object Order vào DB bằng Manager

        //gửi thông báo về trang Store bằng addFlash()

        //quay về trang Store bằng RedirectToRoute()
    }
}
