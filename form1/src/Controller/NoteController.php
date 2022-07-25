<?php

namespace App\Controller;

use App\Entity\Note;
use DateTime;
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
                     //->add("Save", SubmitType::class)
                     ->getForm();
        //dùng form để handle (xử lý) request từ phía client
        $form->handleRequest($request);
        //check xem người dùng đã submit form chưa & dữ liệu trong form có hợp lệ không
        if ($form->isSubmitted() && $form->isValid()) {
            //lấy dữ liệu từ form & lưu vào biến $data
            $data = $form->getData();
            //set giá trị cho từng biến một để đẩy qua view
            $content = $data->content;
            $date = $data->date->format('Y-m-d');
            $image = $data->image;
            //set toàn bộ thông tin vào object $note
            //=> chỉ cần gửi duy nhất biến $note qua view
            $note->setContent($content);
            $note->setImage($image);
            $note->setDate(\DateTime::createFromFormat('Y-m-d',$date));
            //Cách 1: render ra trang success (gửi kèm dữ liệu đã nhập từ form)
            //Note: cách này không thay đổi đường dẫn route (URL)
            // return $this->render('note/success.html.twig',
            // [
            //     // 'content' => $content,
            //     // 'date' => $date,
            //     // 'image' => $image
            //     'note' => $note
            // ]);
            //Cách 2: redirect sang trang success (được render ở function khác)
            //Note: cách này sẽ thay đổi đường dẫn route (URL)
            return $this->redirectToRoute('add_note_success',
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

    #[Route('/success', name: 'add_note_success')]
    public function addNoteSuccess (Request $request) {
        $content = $request->query->get('content');
        $date = $request->query->get('date');
        $image = $request->query->get('image');
        return $this->render('note/success.html.twig',
        [
            'content' => $content,
            'date' => $date,
            'image' => $image
        ]);
    }
}   
