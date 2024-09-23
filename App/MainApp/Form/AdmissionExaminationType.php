<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\AdmissionExamination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdmissionExaminationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date')
            ->add('Faculty')
            ->add('ExaminationSubject')
            ->add('AdmissionPlanPosition')
            ->add('PassScore')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdmissionExamination::class,
        ]);
    }
}
