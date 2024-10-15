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
                'required'=>true
            ])
            ->add('description', NULL,[
                'required'=>false
            ])
            ->add('contactInformation', NULL,[
                'required'=>true
            ])
            ->add('availableDates', NULL,[
                'required'=>true
            ])
            ->add('category', NULL,[
                'required'=>false
            ])
            ->add('location', NULL,[
                'required'=>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lessons::class,
        ]);
    }
}
