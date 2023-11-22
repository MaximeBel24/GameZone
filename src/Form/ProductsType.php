<?php

namespace App\Form;

use Assert\NotBlank;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom ne peut pas être vide.']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Le nom doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.',
                    ]),                   
                ],
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Nom'
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'label' => ' ',
                'choice_label' => 'name',
                'attr' => [
                    'placeholder' => 'Catégorie'
                ],
            ])
            ->add('short_description', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La description ne peut pas être vide.']),
                    new Assert\Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'La description doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
                'label' => ' ',
                'attr' => [
                    'placeholder' => 'Description Courte'
                ],
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La description ne peut pas être vide.']),
                ],
                'attr' => [
                    'placeholder' => 'Description'
                ],
                'label' => ' '
            ])
            ->add('price', NumberType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prix ne peut pas être vide.']),
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'Le prix doit être supérieur à zéro.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Prix'
                ],
                'label' => ' '
            ])
            ->add('stock', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le stock ne peut pas être vide.']),
                    new Assert\GreaterThan([
                        'value' => 0,
                        'message' => 'Le stock doit être supérieur à zéro.',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Stock'
                ],
                'label' => ' '
            ])
            ->add('picture', FileType::class, [
                'attr' => [
                    'placeholder' => 'Photo'
                ],
                'required' => false,
                'label' => ' ',
                'data_class' => null
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
