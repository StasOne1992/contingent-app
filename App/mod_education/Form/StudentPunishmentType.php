<?php

namespace App\mod_education\Form;

use App\mod_education\Entity\Student;
use App\mod_education\Entity\StudentPunishment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentPunishmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date')
            ->add('Student', EntityType::class, [
                'class' => Student::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentPunishment::class,
        ]);
    }
}
