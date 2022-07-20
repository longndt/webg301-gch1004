<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends AbstractController
{
   #[Route('/', name: 'demo')]
   public function demo() {
      return $this->render("demo/test.html.twig");  
   }

   #[Route('/demo1', name: 'demo1')]
   public function demo1() {
      return $this->render("demo/demo1.html.twig");
   }

   #[Route('/demo2', name: 'demo2')]
   public function demo2() {
      return $this->render("demo/demo2.html.twig");
   }

   #[Route('/demo3', name: 'demo3')]
   public function demo3() {
      $name = "Nguyen Van Nam";   //string
      $age = 22;  //integer
      $grade = 8.5;  //float
      $sports = array ("Football", "Badminton", "Swimming", "Volleyball");
      //gửi dữ liệu từ back-end (controller) sang front-end (view)
      //bằng array []
      return $this->render("demo/demo3.html.twig",
            [
               'sports' => $sports,
               'name' => $name,
               'tuoi' => $age,
               'grade' => $grade,
               'diachi' => "Ha Noi - VietNam"        
            ]
      );
   }
}
