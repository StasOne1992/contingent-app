<?php

namespace App\mod_events\Form;

use App\mod_education\Entity\Student;
use App\mod_events\Entity\EventsList;
use App\mod_events\Entity\EventsResult;
use App\mod_events\Entity\EventsResultTypes;
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
