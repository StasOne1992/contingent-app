<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\AdmissionPlan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdmissionPlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('TargetCount')
            ->add('admission')
            ->add('faculty')
            ->add('HaveAdmissionExamination')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdmissionPlan::class,
        ]);
    }
}
