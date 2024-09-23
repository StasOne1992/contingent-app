<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\College;
use App\MainApp\Entity\ModMosregVis;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModMosregVisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('Password')
            ->add('Active')
            ->add('College', EntityType::class, [
                'class' => College::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModMosregVis::class,
        ]);
    }
}
