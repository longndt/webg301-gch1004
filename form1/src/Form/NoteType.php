<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextType::class,
            [
                'required' => true,  //nullable = false
                'label' => 'Nội dung',
                'attr' => 
                [
                    'minlength' => 5,
                    'maxlength' => 20
                ]
            ])
            ->add('image', TextType::class,
            [
                'required' => true,
                'label' => 'Hình ảnh',
            ])
            ->add('date', DateType::class,
            [
                'label' => 'Deadline',
                'required' => true,
                'widget' => 'single_text'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
