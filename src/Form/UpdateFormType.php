<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UpdateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Fields are not required because the user might not want to update every field at once
        $builder 
            ->add('email',
             null, 
             ['required' => false],
             ['label' => 'Email'])
            ->add('password', 
            null, 
            ['required' => false],
            ['label' => 'Email'])
            ->add('avatar', 
            null, 
            ['label' => 'Avatar URL'],
            ['required' => false, 'mapped' => false])
            ->add('username', 
            null, 
            ['label' => 'Username'],
            ['required' => false, 'mapped' => false])
            ->add('description', 
            null, 
            ['label' => 'Description'],
            ['required' => false, 'mapped' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
