<?php
//include_once "Book.php";
require_once "Book.php";

class BookModel {
   //tạo function để hiển thị ra toàn bộ book list
   public function viewBookList() {
      //khởi tạo array để giả lập dữ liệu từ bảng trong DB
      $bookList = array (
         "Symfony Framework" => new Book("Symfony Framework", "David", 99.99,
               "https://realvasi.com/wp-content/uploads/2021/11/Symfony-Features.png"),
          "PHP for Beginner" => new Book("PHP for Beginner", "Michael", 88.88,
               "https://mona.media/wp-content/uploads/2021/11/php-programming-language.png"),
          "MySQL for Students" => new Book("MySQL for Students", "John", 66.66,
               "https://fptcloud.com/wp-content/uploads/2022/03/Tim-hieu-khai-niem-mysql-la-gi.jpg")
         //Note: gán title của book là index trong array
      );
      return $bookList;
   }

   //tạo function để hiển thị thông tin chi tiết của 1 book cụ thể theo title
   public function viewBookDetail($title) {
      $book = $this->viewBookList();
      return $book[$title];
   }
}
?>