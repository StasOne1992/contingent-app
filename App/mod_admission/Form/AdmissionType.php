<?php

namespace App\mod_admission\Form;

use App\mod_admission\Entity\Admission;
use App\mod_admission\Entity\AdmissionStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class AdmissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('dateStart')
            ->add('dateEnd')
            ->add('status', EnumType::class, ['class' => AdmissionStatus::class])
            ->add('IsActive')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admission::class,
        ]);
    }
}
