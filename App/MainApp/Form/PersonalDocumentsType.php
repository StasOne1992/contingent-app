<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\PersonalDocuments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalDocumentsType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DocumentSeries')
            ->add('DocumentNumber')
            ->add('DocumentIssueDate', DateType::class, ['widget' => 'single_text', 'format' => 'yyyy-MM-dd'])
            ->add('DocumentOfficialSeal')
            ->add('Comment')
            ->add('DocumentType')
            ->add('Student');

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PersonalDocuments::class,
        ]);
    }
}
