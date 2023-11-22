<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email',EmailType::class, [
            'attr' => [
                'placeholder' => 'E-mail'
            ],
            'label' => ' ',
            'constraints' => [
                new NotBlank([
                    'message' => 'L\'adresse mail ne peut pas être vide.'
                ]),
            ],
        ])
        ->add('firstname',TextType::class, [
            'attr' => [
                'placeholder' => 'Prénom'
            ],
            'label' => ' ',
            'constraints' => [
                new NotBlank([
                    'message' => 'Le prénom ne peut pas être vide.'
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le prénom ne peut contenir que des lettres.'
                ])
            ],
        ])
        ->add('lastname',TextType::class, [
            'attr' => [
                'placeholder' => 'Nom'
            ],
            'label' => ' ',
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom ne peut pas être vide.'
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le nom ne peut contenir que des lettres.'
                ]),
            ]
        ])
        ->add('subject',TextType::class, [
            'attr' => [
                'placeholder' => 'Sujet'
            ],
            'label' => ' ',
            'constraints' => [
                new NotBlank([
                    'message' => 'Le sujet ne peut pas être vide.'
                ]),
            ],
        ])
        ->add('message', TextareaType::class, [
            'attr' => [
                'placeholder' => 'Message'
            ],
            'label' => ' ',
            'constraints' => [
                new NotBlank([
                    'message' => 'Le message ne peut pas être vide.'
                ]),
                // Ajoutez d'autres contraintes au besoin
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
