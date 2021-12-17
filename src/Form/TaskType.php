<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('createdAt', null, [
            //     'attr' => [
            //     'class' => 'form-control margin-b-10'],
            // ])
            ->add('title', null, [
                'attr' => [
                'class' => 'form-control'],
            ])
            ->add('content' , null ,[
                'attr' => [
                'class' => 'form-control margin-b-10'],
            ])
            // ->add('isDone', null, [
            //     'attr' => [
            //     'class' => 'form-control margin-b-10'],
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
