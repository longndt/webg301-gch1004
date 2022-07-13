<?php 
//khai báo lớp Book đại diện cho bảng Book trong database
class Book {
   //khai báo thuộc tính (attributes) tương ứng với các cột trong bảng
   public $title;
   public $author;
   public $price;
   public $image;

   //khai báo hàm tạo (constructor) với các tham số (parameter) tương ứng  
   public function __construct($t, $a, $p, $i)
   {
      $this->title = $t;
      $this->author = $a;
      $this->price = $p;
      $this->image = $i;
   }
}
?>