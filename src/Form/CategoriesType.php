<?php

namespace App\Form;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Choice;


class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom de catégorie'
                ],
                'label' => ' ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le nom de la catégorie doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le nom de la catégorie ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('slug', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom de slug'
                ],
                'label' => ' ',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide.'
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 50,
                        'minMessage' => 'Le slug doit comporter au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le slug ne peut pas dépasser {{ limit }} caractères.'
                    ]),
                ]
            ])
            ->add('parent', EntityType::class, [
                'class' => Categories::class,
                'required' => false,
                'placeholder' => 'Aucun parent',
                'choice_label' => 'name',
                'label' => ' ',
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
