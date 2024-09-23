<?php

namespace App\mod_mosregvis\Form;

use App\mod_mosregvis\Entity\modMosregVis;
use App\mod_mosregvis\Entity\MosregVISCollege;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class modmosregvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,
                [
                    'label' => 'Имя пользователя',
                    'empty_data' => null,
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Укажите имя пользователя'
                        ]),
                ])
            ->add('password', TextType::class,
                [
                    'label' => 'Пароль для входа',
                    'empty_data' => null,
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Укажите пароль'
                        ]),
                ])
            ->add('mosregVISCollege', EntityType::class, [
                'label' => 'Учебное заведение',
                'placeholder' => 'Укажите учебное заведение',
                'empty_data' => null,
                'attr' => array_merge([
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => MosregVISCollege::class
            ])
            ->add('orgId', TextType::class,
                [
                    'label' => 'GUID организации',
                    'empty_data' => null,
                    'attr' => array_merge([],
                        [
                            'required' => true,
                            'class' => TextType::class . ' form-control',
                            'placeholder' => 'Укажите GUID организации в ВИС'
                        ]),
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => modMosregVis::class,
        ]);
    }
}
