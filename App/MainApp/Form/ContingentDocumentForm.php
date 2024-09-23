<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\College;
use App\MainApp\Entity\ContingentDocument;
use App\MainApp\Entity\ContingentDocumentType;
use App\MainApp\Repository\StudentGroupsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContingentDocumentForm extends AbstractType
{
    public function __construct(
        private StudentGroupsRepository $studentGroupsRepository,
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number', TextType::class, array(
                'label' => 'Номер приказа',
                'empty_data' => null,
                'attr' => [
                    'placeholder' => 'Номер приказа',
                    'required' => false,
                    'class' => TextType::class . ' form-control']
            ))
            ->add('createDate', DateType::class, [
                'label' => 'Дата приказа',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => ' js-flatpickr form-control ',
                    'placeholder' => 'Дата приказа']
            ])
            ->add('type', EntityType::class, array(
                'label' => 'Регион',
                'placeholder' => 'Укажите регион проживания',
                'empty_data' => null,
                'attr' => [
                    'class' => 'form-select',
                ],
                'required' => false,
                'class' => ContingentDocumentType::class))
            ->add('student')
            ->add('name', TextType::class, array(
                'label' => 'Наименование',
                'empty_data' => null,
                'attr' => [
                    'placeholder' => 'Укажите наименование',
                    'required' => false,
                    'class' => TextType::class . ' form-control']
            ))
            ->add('reason', TextType::class, array(
                'label' => 'Причина',
                'empty_data' => null,
                'attr' => [
                    'placeholder' => 'Укажите причину',
                    'required' => false,
                    'class' => TextType::class . ' form-control']
            ))
            ->add('college', EntityType::class, array(
                'label' => 'ПОО',
                'placeholder' => 'Укажите ПОО',
                'empty_data' => null,
                'attr' => [
                    'disabled' => false,
                    'class' => 'form-select',
                ],
                'required' => false,
                'class' => College::class))
            ->add('isActive', CheckboxType::class, [
                'label' => 'Приказ активен',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'type' => 'checkbox',
                    'required' => false,
                ]]);


    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContingentDocument::class,
            'type' => ContingentDocumentType::class,
        ]);
    }
}
