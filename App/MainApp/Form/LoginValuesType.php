<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\LoginValues;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('LoginValue')
            ->add('PasswordValue')
            ->add('Student')
            ->add('LoginProvider')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoginValues::class,
        ]);
    }
}
