<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\Staff;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('FirstName', TextType::class,
                [
                    'label' => 'Имя',
                    'empty_data' => null,
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Укажите имя'
                        ]),
                ])
            ->add('LastName', TextType::class,
                [
                    'label' => 'Фамилия',
                    'empty_data' => null,
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Укажите имя'
                        ]),
                ])
            ->add('MiddleName', TextType::class,
                [
                    'label' => 'Отчество',
                    'empty_data' => null,
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Укажите имя'
                        ]),
                ])
            ->add('Photo')
            ->add('studentGroups')
            ->add('email', EmailType::class,  [
                'label' => 'E-mail',
                'empty_data' => null,
                'attr' => array_merge([],
                    [
                        'required' => true,
                        'class' => TextType::class . ' form-control',
                        'placeholder' => 'E-mail'
                    ]),
            ])
            ->add('UUID', TextType::class,
                [
                    'label' => 'Идентификатор',
                    'empty_data' => null,
                    'disabled' => 'disabled',
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Идентификатор'
                        ]),
                ])
            ->add('College')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Staff::class,
        ]);
    }
}
