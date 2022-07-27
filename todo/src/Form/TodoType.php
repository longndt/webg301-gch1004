<?php

namespace App\Form;

use App\Entity\Todo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,
            [
                'label' => "Todo Title",
                'required' => true,  //optional (nullable == false => not null)
                'attr' => [
                    'minlength' => 5,
                    'maxlength' => 50
                ]
            ])
            ->add('content', TextType::class,
            [
                'label' => "Todo Content",
                'attr' => [
                    'minlength' => 10
                ]
            ])
            ->add('date', DateType::class,
            [
                'label' => "Todo Deadline",
                'widget' => "single_text"
            ])
            ->add('image', TextType::class,
            [
                'label' => "Todo Image"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Todo::class,
        ]);
    }
}
