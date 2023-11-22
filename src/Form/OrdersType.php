<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class OrdersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('total_price', NumberType::class,[
                'attr' => [
                    'placeholder' => 'Prix Total'
                ],
                'label' => ' ',
                'constraints' => [
                    new Range([
                        'min' => 0,
                        'minMessage' => 'Le prix total doit être un nombre positif ou nul.',
                    ]),
                ]
            ])
            ->add('status',ChoiceType::class,[
                'choices' => [
                    'en cours de traitement'=>'en cours de traitement',
                    'envoyé'=>'envoyé',
                    'livré'=>"livré"
                ],
                'attr' => [
                    'placeholder' => 'Etat de la commande'
                ],
                'label' => ' ',
                'constraints' => [
                    new Choice([
                        'choices' => [
                            'en cours de traitement',
                            'envoyé',
                            'livré'
                        ],
                        'message' => 'Choisissez un état de commande valide parmi les options disponibles.'
                    ]),
                ],
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
