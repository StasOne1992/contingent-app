<?php

namespace App\mod_education\Form;

use App\mod_education\Entity\SocialNetwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SocialNetworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('SocialNetworkLink')
            ->add('StudetnID')
            ->add('SocialNetworkTypeID')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SocialNetwork::class,
        ]);
    }
}
