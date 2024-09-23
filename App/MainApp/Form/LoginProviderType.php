<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\LoginProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginProviderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('loginKey')
            ->add('PasswordKey')
            ->add('AuthPath')
            ->add('CustomParams')
            ->add('UserCanLogin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LoginProvider::class,
        ]);
    }
}
