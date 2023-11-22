<?php

namespace App\Form;

use Assert\EqualTo;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder            
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'E-mail'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L\'adresse e-mail ne peut pas être vide.']),
                    new Assert\Email(['message' => 'L\'adresse e-mail n\'est pas valide.']),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Mot de passe'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le mot de passe ne peut pas être vide.']),
                    new Assert\Length(['min' => 6, 'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.']),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [
                'mapped' => false,
                'invalid_message' => "Les mots de passe ne correspondent pas.",
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => 'Confirmer le mot de passe'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Veuillez confirmer le mot de passe.']),
                                      
                ],
            ])
            ->add('username', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom d\'utilisateur'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom d\'utilisateur ne peut pas être vide.']),
                    new Assert\Length(['min' => 3, 'minMessage' => 'Le nom d\'utilisateur doit contenir au moins {{ limit }} caractères.']),
                ],
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le prénom ne peut pas être vide.']),
                    new Assert\Regex([
                        'pattern' => '/\d/',
                        'match' => false,
                        'message' => 'Le prénom ne peut pas contenir de chiffres.',
                    ]),
                ],
            ])
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom de famille'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom de famille ne peut pas être vide.']),
                    new Assert\Regex([
                        'pattern' => '/\d/',
                        'match' => false,
                        'message' => 'Le prénom ne peut pas contenir de chiffres.',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => [
                    'placeholder' => 'Adresse'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'L\'adresse ne peut pas être vide.']),
                ],
            ])
            ->add('zipcode', TextType::class, [
                'attr' => [
                    'placeholder' => 'Code postal'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le code postal ne peut pas être vide.']),
                    new Assert\Regex([
                        'pattern' => '/^\d+$/', // Expression régulière pour n'autoriser que des chiffres
                        'message' => 'Le code postal ne peut contenir que des chiffres.',
                    ]),
                ],
            ])
            ->add('city', TextType::class, [
                'attr' => [
                    'placeholder' => 'Ville'
                ],
                'label' => ' ',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'La ville ne peut pas être vide.']),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
