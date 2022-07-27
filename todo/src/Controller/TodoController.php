<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
   #[Route('/todo/viewall', name: 'view_all_todo')]
   public function TodoIndex(TodoRepository $todoRepository, ManagerRegistry $managerRegistry) {
    //lưu ý: import Manager Registry thì dùng thư viện của Doctrine thay vì Symfony
    //lấy dữ liệu từ bảng Todo trong DB
    //Cách 1 
    $todos = $todoRepository->findAll();  
    //Cách 2
    //$todos = $this->getDoctrine()->getRepository(Todo::class)->findAll();
    //Cách 3
    //$todos = $managerRegistry->getRepository(Todo::class)->findAll();
    //render ra view và trả về dữ liệu
    return $this->render("todo/index.html.twig",
        [
            'todos' => $todos
        ]);
   }

   #[Route('/todo/view/{id}', name: 'view_todo_by_id')]
   public function TodoDetail($id) {
     //gọi ra todo theo id
     $todo = $this->getDoctrine()->getRepository(Todo::class)->find($id);
     //kiểm tra xem id có tồn tại không => biến $todo có null không
     if ($todo != null) {
        return $this->render("todo/detail.html.twig",
        [
            'todo' => $todo
        ]);
     } else { //$todo == null
        //gửi thông báo lỗi về front-end (client-side) bằng flash message
        $this->addFlash("Error", "Todo not found !");
        //redirect về trang home
        return $this->redirectToRoute("view_all_todo");
     } 
   }

   #[Route('/todo/delete/{id}', name: 'delete_todo')]
   public function TodoDelete($id, ManagerRegistry $managerRegistry) {
     $todo = $managerRegistry->getRepository(Todo::class)->find($id);
     if ($todo == null) {
        $this->addFlash("Error", "Todo not found !");
     } else {  //$todo != null
        //gọi đến entity (object) manager để xóa todo
        $manager = $managerRegistry->getManager();
        $manager->remove($todo);
        $manager->flush();
        $this->addFlash("Success", "Delete todo succeed !");
     }
     return $this->redirectToRoute("view_all_todo");
   }
}
