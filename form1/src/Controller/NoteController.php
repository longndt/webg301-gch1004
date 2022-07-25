<?php

namespace App\Controller;

use App\Entity\Note;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController
{
    //Cách 1: sử dùng hàm createFormBuilder()
    //=> Tạo form ngay trong Controller
    #[Route('/create', name: 'create_new_note')]
    public function createNewNote(Request $request) {
        //tạo 1 object $note mới để lưu thông tin nhập từ form
        $note = new Note;
        //tạo form để người dùng nhập
        //dữ liệu người dùng nhập vào sẽ lưu vào $note
        $form = $this->createFormBuilder($note)
                     ->add("content", TextType::class)
                     ->add("image", TextType::class)
                     ->add("date", DateType::class,
                     [
                        'widget' => 'single_text'
                     ])
                     ->add("Save", SubmitType::class)
                     ->getForm();
        //dùng form để handle (xử lý) request từ phía client
        $form->handleRequest($request);
        //check xem người dùng đã submit form chưa & dữ liệu trong form có hợp lệ không
        if ($form->isSubmitted() && $form->isValid()) {
            //lấy dữ liệu từ form & lưu vào biến $data
            $data = $form->getData();
            //set dữ liệu cho biến $content & $date
            $content = $data->content;
            $date = $data->date->format('Y-m-d');
            $image = $data->image;
            //render ra thẳng trang success (gửi kèm dữ liệu đã nhập từ form)
            return $this->render('note/success.html.twig',
            [
                'content' => $content,
                'date' => $date,
                'image' => $image
            ]);
        }
        //render ra form để người dùng nhập liệu
        //Cách 1: dùng hàm render() và createView()
        return $this->render('note/create.html.twig',
        [
            'noteForm' => $form->createView()
        ]);
    }       

    //Cách 2: sử dùng hàm createForm() => recommend
    //=> Tạo form ở file form riêng và gọi đến trong Controller
    #[Route('/make', name: 'make_new_note')]
    public function makeNewNote() {
        $note = new Note;
    }
}   
