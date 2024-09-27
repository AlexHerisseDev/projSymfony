<?php

namespace App\Form;

use App\Entity\Lessons;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateLessonFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', NULL,[
                'required'=>false
            ])
            ->add('description', NULL,[
                'required'=>false
            ])
            ->add('contactInformation', NULL,[
                'required'=>false
            ])
            ->add('availableDates', NULL,[
                'required'=>false
            ])
            ->add('category', NULL,[
                'required'=>false
            ])
            // ->add('lessonsStudents')
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
