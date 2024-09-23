<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\LegalRepresentative;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LegalRepresentativeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName')
            ->add('LastName')
            ->add('MiddleName')
            ->add('Phone')
            ->add('Comment')
            ->add('RepresentativesType')
            ->add('StudentID')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LegalRepresentative::class,
        ]);
    }
}
