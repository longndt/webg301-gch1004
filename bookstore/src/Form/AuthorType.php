<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,
            [
                'required' => true,
                'label' => 'Author name',
                'attr' => [
                    'minlength' => 3,
                    'maxlength' => 30
                ]
            ])
            ->add('age', IntegerType::class,
            [
                'required' => true,
                'label' => 'Author age',
                'attr' => [
                    'min' => 15,
                    'max' => 85
                ]
            ])
            ->add('image', TextType::class,
            [
                'required' => true,
                'label' => 'Author image',
                'attr' => [
                    'maxlength' => 255
                ]
            ])
            //->add('books')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
