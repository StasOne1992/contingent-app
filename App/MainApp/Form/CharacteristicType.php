<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\Characteristic;
use App\MainApp\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacteristicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CreateData', DateType::class,
                [
                    'label' => 'Дата выдачи',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd'
                ]
            )
            ->add('Content')
            ->add('Student', EntityType::class, array(
                'label' => 'Студент',
                'placeholder' => 'Укажите студента',
                'empty_data' => null,
                'class' => Student::class));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Characteristic::class,
            'Student' => Student::class
        ]);
    }
}
