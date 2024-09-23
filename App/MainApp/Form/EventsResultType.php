<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\EventsList;
use App\MainApp\Entity\EventsResult;
use App\MainApp\Entity\EventsResultTypes;
use App\MainApp\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsResultType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (isset($options['data']->lockStudent)&&$options['data']->lockStudent) {
            $readOnly = ['readonly' => 'readonly'];
            $disabled = ['disabled' => 'disabled'];
            $disabled_DP = ['disabled' => 'true'];
        } else {
            $readOnly = [' ' => ' '];
            $disabled = [' ' => ' '];
            $disabled_DP = [' ' => ' '];
        }
        $builder
            ->add('Event', EntityType::class, [
                'class' => EventsList::class,
                'choice_label' => 'Name',
            ])
            ->add('Student', EntityType::class, array(
                'label' => 'Позиция плана приёма',
                'placeholder' => 'Укажите позицию плана приёма',
                'empty_data' => null,
                'attr' => array_merge($disabled, [
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => Student::class))
            ->add('ResultType', EntityType::class, [
                'class' => EventsResultTypes::class,
                'choice_label' => 'Name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventsResult::class,
        ]);
    }
}
