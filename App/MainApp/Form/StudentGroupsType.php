<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\EducationPlan;
use App\MainApp\Entity\Faculty;
use App\MainApp\Entity\Staff;
use App\MainApp\Entity\StudentGroups;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentGroupsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Name', TextType::class,
                [
                    'label' => 'Наименование группы',
                    'empty_data' => null,
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Укажите наименование группы'
                        ]),
                ])
            ->add('EducationPlan', EntityType::class, [
                'label' => 'Учебный план',
                'placeholder' => 'Укажите учебны план',
                'empty_data' => null,
                'attr' => array_merge([
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => EducationPlan::class
            ])
            ->add('faculty', EntityType::class, array(
                'label' => 'Направление подготовки',
                'placeholder' => 'Укажите направление подготовки',
                'empty_data' => null,
                'attr' => array_merge([
                    'required' => true,
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => Faculty::class))
            ->add('code', TextType::class, [
                'label' => 'Код группы',
                'required' => false,
                'attr' => array_merge([
                    'class' => 'form-control'
                ])
            ])
            ->add('CourseNumber', NumberType::class, [
                'label' => 'Текущий курс',
                'required' => false,
                'attr' => array_merge([
                    'required' => true,
                    'class' => 'form-control'
                ])
            ])
            ->add('ParallelNumber', NumberType::class, [
                'label' => 'Параллель',
                'required' => false,
                'attr' => array_merge([
                    'required' => true,
                    'class' => 'form-control'
                ])])
            ->add('groupLeader', EntityType::class, array(
                'label' => 'Классный руководитель',
                'placeholder' => 'Укажите классного руководителя',
                'empty_data' => null,
                'attr' => array_merge([
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => Staff::class))


            ->add('DateStart', DateType::class, [
                'label' => 'Дата начала обучения',
                'widget' => 'single_text',
                'html5' => false,
                'empty_data' => '',
                'attr' => array_merge([
                    'class' => ' js-flatpickr form-control ',
                    'required' => false,
                    'placeholder' => 'Дата начала обучения'
                ])
            ])
            ->add('DataEnd', DateType::class, [
                'label' => 'Дата завершения обучения',

                'widget' => 'single_text',
                'html5' => false,
                'empty_data' => '',
                'attr' => array_merge([
                    'class' => ' js-flatpickr form-control ',
                    'required' => false,
                    'placeholder' => 'Дата завершения обучения'
                ])
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StudentGroups::class,
        ]);
    }
}
