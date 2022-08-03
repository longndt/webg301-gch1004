<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',  TextType::class,
            [
                'required' => true,
                'label' => 'Book Title',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30
                ]
            ])
            ->add('quantity', IntegerType::class,
            [
                'required' => true,
                'label' => 'Book Quantity',
                'attr' => [
                    'min' => 1,
                    'max' => 100
                ]
            ])
            ->add('price', MoneyType::class,
            [
                'required' => true,
                'label' => 'Book Price',
                'currency' => 'USD'
            ])
            ->add('date', DateType::class,
            [
                'required' => true,
                'label' => 'Published Date',
                'widget' => 'single_text'
            ])
            ->add('image', TextType::class,
            [
                'required' => true,
                'label' => 'Book image',
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            ->add('genre', EntityType::class,
            [
                 'required' => true,
                 'label' => 'Book genre',
                 'class' => Genre::class,
                 'choice_label' => 'name',
                 'multiple' => false,
                 'expanded' => false
            ])
            ->add('authors', EntityType::class,
            [
                 'required' => true,
                 'label' => 'Author(s)',
                 'class' => Author::class,
                 'choice_label' => 'name',
                 'multiple' =>  true,
                 'expanded' => true
            ])
            //Notes:
            /*
                 'multiple' => false,
                 'expanded' => false
                 => Drop-down list (single choice)

                 'multiple' => false,
                 'expanded' => true
                 => Radio button

                 'multiple' => true,
                 'expanded' => false
                 => Drop-down list (multiple choices) : Hold CTRL button to select many

                'multiple' => true,
                 'expanded' => true
                 => Checkbox
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
