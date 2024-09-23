<?php

namespace App\MainApp\Form\dashboard;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DashboardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        dd($options);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {

    }

}