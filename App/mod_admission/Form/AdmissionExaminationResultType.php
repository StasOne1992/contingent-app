<?php

namespace App\mod_admission\Form;

use App\mod_admission\Entity\AdmissionExaminationResult;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdmissionExaminationResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Mark')
            ->add('AbiturientPetition')
            ->add('AdmissionExamination')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AdmissionExaminationResult::class,
        ]);
    }
}
