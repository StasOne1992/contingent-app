<?php

namespace App\mod_admission\Form;

use App\mod_admission\Entity\AdmissionExaminationSubjects;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdmissionExaminationSubjectsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdmissionExaminationSubjects::class,
        ]);
    }
}
