<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'attr' => [
                'class' => 'form-control'],
                'constraints' => 
                [
                    new NotBlank([
                        'message' => 'Entrez un titre',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le titre doit être supérieur ou égal à {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('content' , null ,[
                'attr' => [
                'class' => 'form-control margin-b-10'],
                'constraints' => 
                [
                    new NotBlank([
                        'message' => 'Entrez un contenu',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le nom contenu doit être supérieur ou égal à {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
