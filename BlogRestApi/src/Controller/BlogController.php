<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
   //khai báo thư viện SerializerInterface để chuyển đổi dữ liệu từ bảng trong DB
   //thành API theo định dạng JSON hoặc XML
   public $serializerInterface;

   public function __construct(SerializerInterface $serializerInterface)
   {
     $this->serializerInterface = $serializerInterface;
   }

   //SQL Query: SELECT * FROM Blog
   #[Route('/blog', methods: 'GET', name: 'view_all_blog_api')]
   public function viewAllBlog (BlogRepository $blogRepository, ManagerRegistry $managerRegistry)  {
     //lấy dữ liệu từ bảng Blog và lưu vào array
     //Cách 1: dùng repository (phải import class Repository)
     //$blogs = $blogRepository->findAll();
     //Cách 2: dùng getRepository (không cần import gì cả)
     //$blogs = $this->getDoctrine()->getRepository(Blog::class)->findAll();
     //Cách 3: dùng ManagerRegistry (phải import ManagerRegistry)
     $blogs = $managerRegistry->getRepository(Blog::class)->findAll();

     //convert array thành api (format: json hoặc xml)
     $api = $this->serializerInterface->serialize($blogs,'json');
     //trả về 1 response chứa api 
     return new Response($api, 
                         Response::HTTP_OK , // code: 200
                         [
                            'content-type' => 'application/json'
                         ]
     );
   }

   //SQL Query: SELECT * FROM Blog WHERE id = '$id'
   #[Route('/blog/{id}', methods: 'GET', name: 'view_blog_by_id_api')]
   public function viewBlogById ($id) {

   }

   //SQL Query: DELETE FROM Blog WHERE id = '$id'
   #[Route('/blog/{id}', methods: 'DELETE', name: 'delete_blog_api')]
   public function deleteBlog ($id) {

   }

   //SQL Query: INSERT INTO Blog (....) VALUES (....)
   #[Route('/blog', methods: 'POST', name: 'add_blog_api')]
   public function addBlog () {

   }

   //SQL Query: UPDATE Blog WHERE id = '$id'
   #[Route('/blog/{id}', methods: 'PUT', name: 'update_blog_api')]
   public function updateBlog ($id) {

   }
}
