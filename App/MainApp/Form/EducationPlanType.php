<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\EducationPlan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationPlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title')
            ->add('Faculty')
            ->add('DateStart')
            ->add('DateEnd')
            ->add('Qualification')
            ->add('EducationForm')
            ->add('BaseEducationType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EducationPlan::class,
        ]);
    }
}
