<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

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
     //Cách 1: dùng repository (cần import class Repository)
     //$blogs = $blogRepository->findAll();
     //Cách 2: dùng getRepository (không cần import class nào cả)
     //$blogs = $this->getDoctrine()->getRepository(Blog::class)->findAll();
     //Cách 3: dùng ManagerRegistry (cần import class ManagerRegistry)
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
   public function viewBlogById ($id, BlogRepository $blogRepository, ManagerRegistry $managerRegistry) {
    //Bước 1: lấy dữ liệu từ DB
    //Cách 1
    //$blog = $blogRepository->find($id);
    //Cách 2
    //$blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
    //Cách 3
    $blog = $managerRegistry->getRepository(Blog::class)->find($id);
    //Kiểm tra dữ liệu có null hay không
    if ($blog != null) {
      //Bước 2: convert dữ liệu thành api theo format json hoặc xml
      $data = $this->serializerInterface->serialize($blog ,"json");
      //Bước 3: trả api về client
      return new Response($data, 200,
                [
                  'content-type' => 'application/json'
                ]);
    }
    else {  //$blog == null
      $error = "Blog not found !";
      return new Response($error, Response::HTTP_NOT_FOUND, //404
                [
                  'content-type' => 'text/html'
                ]);
    }
   }

   //SQL Query: DELETE FROM Blog WHERE id = '$id'
   #[Route('/blog/{id}', methods: 'DELETE', name: 'delete_blog_api')]
   public function deleteBlog ($id) {
     $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
     //id có tồn tại => $blog != null
     //id không tồn tại => $blog == null
     if ($blog == null) {
       $error = "Can not delete (Id not found)";
       return new Response($error, Response::HTTP_BAD_REQUEST);  //code: 400
     }
     else {  //$blog != null
       $manager = $this->getDoctrine()->getManager();  //entity (object) manager
       $manager->remove($blog);
       $manager->flush();
       return new Response("Delete succeed !", Response::HTTP_ACCEPTED);
     }
   }

   //SQL Query: INSERT INTO Blog (....) VALUES (....)
   #[Route('/blog', methods: 'POST', name: 'add_blog_api')]
   public function addBlog (Request $request, ManagerRegistry $managerRegistry) {
      //tạo mới object Blog để lưu dữ liệu
      $blog = new Blog;
      //tạo biến $data để lấy dữ liệu từ request của client
      //json_decode : giải mã dữ liệu từ format của json
      $data = json_decode($request->getContent(),true); 
      //set dữ liệu của từng thông tin vào biến $blog từ biến $data
      $blog->setTitle($data['title']);
      $blog->setContent($data['content']);
      $blog->setDate(\DateTime::createFromFormat("Y-m-d",$data['date']));
      //lưu dữ liệu của biến $blog vào DB thông qua entity manager
      $manager = $managerRegistry->getManager();
      $manager->persist($blog);
      $manager->flush();
      //trả response về client
      $message = "Add new blog succeed !";
      return new Response($message, Response::HTTP_CREATED); //response code: 201
   }

   //SQL Query: UPDATE Blog WHERE id = '$id'
   #[Route('/blog/{id}', methods: 'PUT', name: 'update_blog_api')]
   public function updateBlog ($id, Request $request) {
      //lấy ra object của $blog theo id 
      $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
      if ($blog != null) {
        //decode dữ liệu json gửi từ client về server
        $data = json_decode($request->getContent(),true);
        //set dữ liệu từ $data vào các thuộc tính trong $blog
        $blog->setContent($data['content']);
        $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));
        $blog->setTitle($data['title']);
        //dùng entity (object) manager để update dữ liệu vào DB
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($blog);
        $manager->flush();
        //trả về response cho client
        return new Response("Update blog succeed", Response::HTTP_ACCEPTED); //code: 202
      }
      else {  //$blog == null
        return new Response("Blog id not found => Can not update");
      }
    }
}
