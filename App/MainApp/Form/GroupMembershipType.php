<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\ContingentDocument;
use App\MainApp\Entity\GroupMembership;
use App\MainApp\Entity\Student;
use App\MainApp\Entity\StudentGroups;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupMembershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateStart')
            ->add('DateEnd')
            ->add('Student', EntityType::class, [
                'class' => Student::class,
'choice_label' => 'id',
            ])
            ->add('StudentGroup', EntityType::class, [
                'class' => StudentGroups::class,
'choice_label' => 'id',
            ])
            ->add('ContingentDocument', EntityType::class, [
                'class' => ContingentDocument::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => GroupMembership::class,
        ]);
    }
}
