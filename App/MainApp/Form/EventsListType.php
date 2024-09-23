<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\EventsCategory;
use App\MainApp\Entity\EventsLevel;
use App\MainApp\Entity\EventsList;
use App\MainApp\Entity\EventsPlaces;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventsListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class, array(
                'label' => 'Наименование',
                'empty_data' => null,
                'attr' => array_merge([
                    'required' => true,
                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите наименование мероприятия',])))
            ->add('EventDate', DateType::class, [
                'label' => 'Дата мероприятия',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => array_merge([
                    'class' => ' js-flatpickr form-control ',
                    'placeholder' => 'Дата мероприятия',

                ])],
            )

            ->add('EventStartTime', TimeType::class, [
                'label' => 'Начало мероприятия',
                'widget' => 'single_text',
                'placeholder' => ['hour' => 'Hour', 'minute' => 'Minute'],
                'attr' => [
                    'class' => ' js-flatpickr form-control ',
                    'data-enable-time' => 'true',
                    'data-no-calendar' => 'true',
                    'data-date-format' => 'H:i',
                    'data-time_24hr' => 'true'
                ]
            ])
            ->add('EventEndTime', TimeType::class, [
                'label' => 'Завершение мероприятия',
                'widget' => 'single_text',
                'placeholder' => ['hour' => 'Hour', 'minute' => 'Minute'],
                'attr' => [
                    'class' => ' js-flatpickr form-control ',
                    'data-enable-time' => 'true',
                    'data-no-calendar' => 'true',
                    'data-date-format' => 'H:i',
                    'data-time_24hr' => 'true'
                ]
            ])
            ->add('Comment', TextareaType::class, array(
                'required' => false,
                'label' => 'Описание мероприятия (при наличии)',
                'empty_data' => null,
                'attr' => array_merge([
                        'placeholder' => 'Описание мероприятия (при наличии)',
                        'required' => false,
                        'class' => TextareaType::class . ' form-control']
                )))
            ->add('EventCategory', EntityType::class, array(
                'label' => 'Модуль',
                'placeholder' => 'Укажите модуль',
                'empty_data' => null,
                'attr' => array_merge([
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => EventsCategory::class
            ))
            ->add('EventLevel', EntityType::class, array(
                'label' => 'Уровень',
                'placeholder' => 'Укажите уровень',
                'empty_data' => null,
                'attr' => array_merge([
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => EventsLevel::class))
            ->add('EventPlace', EntityType::class, array(
                'label' => 'Пол',
                'placeholder' => 'Укажите пол',
                'empty_data' => null,
                'attr' => array_merge([
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => EventsPlaces::class))
            ->add('IsPublic', CheckboxType::class, [
                'label' => 'Опубликовать мероприятие в календаре ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('IsCanHaveResults', CheckboxType::class, [
                'label' => 'Для мероприятия предусмотрены результаты',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('IsGroupEvent', CheckboxType::class, [
                'label' => 'Мероприятие групповое',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('IsArchived', CheckboxType::class, [
                'label' => 'В архиве',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventsList::class,
        ]);
    }
}
