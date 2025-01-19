<?php

namespace App\mod_education\Form;

use App\mod_education\Entity\EducationPlan;
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
            ->add('Faculty')
            ->add('DateStart', DateType::class, [
                'label' => 'Дата начала обучения',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd'])
            ->add('DateEnd')
            ->add('Qualification')
            ->add('EducationForm')
            ->add('BaseEducationType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EducationPlan::class,
        ]);
    }
}
