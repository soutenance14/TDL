<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class' => 'form-control'],
                'constraints' => 
                [
                    new NotBlank([
                        'message' => 'Entrez un nom d\'utilisateur',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom d\'utilisateur doit être supérieur ou égal à {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control'],
                'label' => 'Roles de l\'utilisateur',
                'choices' => ['ROLE_ADMIN' => 'ROLE_ADMIN', 'ROLE_USER' => 'ROLE_USER'],
                'multiple' => true
            ])
            ->add('password', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => 
                [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit être supérieur ou égal à {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'first_options'  => ['label' => 'Mot de passe', 'attr'=> [
                    'class' => 'form-control'
                    ]
                ],
                    'second_options' => ['label' => 'Tapez le mot de passe à nouveau', 'attr'=> [
                        'class' => 'form-control'
                        ]
                    ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control margin-b-10']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
