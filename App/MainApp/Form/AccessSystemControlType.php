<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\AccessSystemControl;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccessSystemControlType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('AccessCardSeries')
            ->add('AccesCardNumber')
            ->add('IssueDate')
            ->add('IsLocked')
            ->add('LockDate')
            ->add('Student')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccessSystemControl::class,
        ]);
    }
}
