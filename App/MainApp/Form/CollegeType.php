<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\College;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollegeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('shortName')
            ->add('postalAddress')
            ->add('registeredAddress')
            ->add('email')
            ->add('webSite')
            ->add('logo')
            ->add('phone')
            ->add('fax')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => College::class,
        ]);
    }
}
