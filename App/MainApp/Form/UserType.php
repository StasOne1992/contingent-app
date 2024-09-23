<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\staff;
use App\MainApp\Entity\Student;
use App\MainApp\Entity\User;
use App\MainApp\Repository\RolesRepository;
use App\MainApp\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    public function __construct(RolesRepository $rolesRepository, UserRepository $userRepository)
    {
        foreach ($rolesRepository->findAllActiveAsArray() as $role) {
            $this->sysroles[$role['Name']] = $role['RoleName'];
        }
        $this->UserRepo = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $isstudentValue = $options['data']->isIsStudent();
        $isstaff = false;
        $isstudent = false;
        if ($isstudentValue == true) {
            $studentClass = 'form-check-input';
            $staffClass = 'form-check-input ' . 'd-none';
        } else {
            $studentClass = 'form-check-input' . 'd-none';
            $staffClass = 'form-check-input ';
        }

        $builder
            ->add('email', EmailType::class)
            ->add('password')
            ->add('userphoto')
            ->add('isStudent', CheckboxType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('student', EntityType::class, array(
                'label' => 'Связь со студентом',
                'placeholder' => 'Укажите студента',
                'empty_data' => null,
                'required' => $isstudent,
                'class' => Student::class))
            ->add('staff', EntityType::class, array(
                'label' => 'Связь с сотрудником',
                'placeholder' => 'Укажите сотрудника',
                'empty_data' => null,
                'required' => $isstudent,
                'class' => staff::class))
            ->add('roles', TextType::class)
            ->add('systemroles', ChoiceType::class, [
                    'attr' => ['id' => 'systemroles'],
                    'label' => 'Your Field',
                    'required' => true,
                    'multiple' => true,
                    'expanded' => true,
                    'choices' => $this->sysroles,
                    'mapped' => false]
            );

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray): string {

                    // transform the array to a string
                    return implode(',', $tagsAsArray);
                },
                function ($tagsAsString): array {
                    // transform the string back to an array
                    return explode(',', $tagsAsString);
                }
            ));


    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
