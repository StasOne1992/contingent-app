<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName')
            ->add('LastName')
            ->add('MiddleName')
            ->add('INN')
            ->add('SNILS')
            ->add('MedicalSeries')
            ->add('MedicalNumber')
            ->add('BirthPlace')
            ->add('MedicalDateIssue')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Person::class,
        ]);
    }
}
