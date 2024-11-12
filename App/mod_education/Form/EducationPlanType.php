<?php

namespace App\mod_education\Form;

use App\mod_education\Entity\EducationForm;
use App\mod_education\Entity\EducationPlan;
use App\mod_education\Entity\EducationType;
use App\mod_education\Entity\Faculty;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationPlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Title', TextType::class, array(
                'label' => 'Наименование',
                'empty_data' => null,
                'attr' => [
                    'placeholder' => 'Укажите наименование',
                    'required' => false,
                    'class' => TextType::class . ' form-control']
            ))
            ->add('Faculty', EntityType::class, [
                'label' => 'Специальность',
                'placeholder' => 'Выберите специальность',
                'empty_data' => null,
                'required' => false,
                'class' => Faculty::class,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('DateStart', DateType::class, [
                'label' => 'Начало обучения',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'])
            ->add('DateEnd', DateType::class, [
                'label' => 'Окончание обучения',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'])
            ->add('Qualification', TextType::class, [
                'label' => 'Квалификация',

                'required' => false,
                'attr' => [
                    'placeholder' => 'Укажите квалификацию',
                    'class' => 'form-control',
                ],
            ])
            ->add('EducationForm', EntityType::class, [
                'label' => 'Форма обучения',
                'placeholder' => 'Выберите форму обучения',
                'empty_data' => null,
                'required' => false,
                'class' => EducationForm::class,
                'attr' => [
                    'class' => 'form-control',
                ]])
            ->add('BaseEducationType', EntityType::class, [
                'label' => 'Вид образования',
                'placeholder' => 'Выберите вид образования',
                'empty_data' => null,
                'required' => false,
                'class' => EducationType::class,
                'attr' => [
                    'class' => 'form-control',
                ]]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EducationPlan::class,
        ]);
    }
}
