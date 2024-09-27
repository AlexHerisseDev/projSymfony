<?php

namespace App\Form;

use App\Entity\Lessons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LessonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description', NULL,[
                'required'=>false
            ])
            ->add('contactInformation')
            ->add('availableDates')
            ->add('category', NULL,[
                'required'=>false
            ])
            // ->add('teacher_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lessons::class,
        ]);
    }
}
