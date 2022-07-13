<?php
require_once "model/BookModel.php";
//tạo controller để lấy dữ liệu từ model và render ra view 
class BookController {
   public $model;
   public function __construct()
   {
      $this->model = new BookModel;
   }

   //tạo function để handle request của người dùng (client)
   public function handle() {
      //TH1: render ra trang BookList (homepage) nếu đường dẫn url không có tham số về book title
      if (!isset($_GET['title'])) {
         //lấy dữ liệu từ model
         $bookList = $this->model->viewBookList();
         //render ra view
         require_once "view/BookList.php";
       
      }

      //TH2: render ra trang BookDetail nếu đường dẫn url có tham số về book title
      else {
         $book = $this->model->viewBookDetail($_GET['title']);
         require_once "view/BookDetail.php";
      }
   }
}
?>