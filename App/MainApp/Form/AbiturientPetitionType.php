<?php

namespace App\MainApp\Form;

use App\MainApp\Entity\AbiturientPetition;
use App\MainApp\Entity\AbiturientPetitionStatus;
use App\MainApp\Entity\Admission;
use App\MainApp\Entity\AdmissionPlan;
use App\MainApp\Entity\Faculty;
use App\MainApp\Entity\Gender;
use App\MainApp\Entity\Regions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class AbiturientPetitionType extends AbstractType
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker
    )
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (!$this->authorizationChecker->isGranted('ROLE_STAFF_AB_PETITIONS_MANUAL_C')) {
            $readOnly = ['readonly' => 'readonly'];
            $disabled = ['disabled' => 'disabled'];
            $disabled_DP = ['disabled' => 'true'];
        } else {
            $readOnly = [' ' => ' '];
            $disabled = [' ' => ' '];
            $disabled_DP = [' ' => ' '];
        }
        $builder
            ->add('GUID', TextType::class, array(
                'label' => 'GUID',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                    'required' => false,

                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите GUID заявления',])))
            ->add('number', TextType::class, array(
                'label' => 'Номер в ВИС',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите номер заявления в ВИС',
                        'required' => false,
                        'class' => TextType::class . ' form-control']
                )))
            ->add('firstName', TextType::class, array(
                'label' => 'Имя',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите имя',
                        'required' => false,
                        'class' => TextType::class . ' form-control']
                )))
            ->add('lastName', TextType::class, array(
                'label' => 'Фамилия',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите фамилию',
                        'required' => false,
                        'class' => TextType::class . ' form-control']
                )))
            ->add('middleName', TextType::class, array(
                'label' => 'Отчество',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                    'placeholder' => 'Укажите отчество',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('documentSNILS', TextType::class, array(
                'label' => 'СНИЛС',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите СНИЛС',
                        'required' => false,
                        'class' => TextType::class . ' form-control']
                )))
            ->add('createdTs', DateType::class, [
                'label' => 'Дата создания ВИС',
                'widget' => 'single_text',
                'html5' => false,
                'attr' => array_merge($readOnly, $disabled_DP, [
                    'class' => ' js-flatpickr form-control ',
                    'placeholder' => 'Дата создания ВИС',

                ])
            ],
            )
            ->add('BirthDate', DateType::class, [
                'label' => 'Дата рождения',

                'widget' => 'single_text',
                'html5' => false,
                'empty_data' => '',
                'attr' => array_merge($readOnly, $disabled_DP, [
                    'class' => ' js-flatpickr form-control ',
                    'required' => false,
                    'placeholder' => 'Дата рождения'
                ])
            ],
            )
            ->add('PasportDateObtain', DateType::class, [
                'label' => 'Дата выдачи паспорта',
                'widget' => 'single_text',
                'html5' => false,
                'empty_data' => '',
                'attr' => array_merge($readOnly, $disabled_DP, [
                    'class' => ' js-flatpickr form-control ',
                    'required' => false,
                    'placeholder' => 'Дата выдачи паспорта'
                ])
            ],
            )
            ->add('DateProvision', DateType::class, [
                'label' => 'Дата решения',
                'widget' => 'single_text',
                'empty_data' => '',
                'html5' => false,
                'attr' => array_merge([
                    'required' => false,
                    'class' => ' js-flatpickr form-control ',
                    'placeholder' => 'Дата решения'
                ])
            ],
            )
            ->add('DateCancel', DateType::class, [
                'label' => 'Дата отказа',
                'widget' => 'single_text',
                'empty_data' => '',
                'html5' => false,
                'attr' => array_merge([
                    'required' => false,
                    'class' => 'js-flatpickr form-control ',
                    'placeholder' => 'Дата отказа'
                ])
            ],
            )
            ->add('TargetAgreementDate', DateType::class, [
                'label' => 'Дата подписания',
                'widget' => 'single_text',
                'empty_data' => '',
                'html5' => false,
                'required' => false,
                'attr' => array_merge([
                    'required' => false,
                    'class' => 'js-flatpickr form-control ',
                    'placeholder' => 'Дата подписания целевого договора'
                ])
            ],
            )
            ->add('gender', EntityType::class, array(
                'label' => 'Пол',
                'placeholder' => 'Укажите пол',
                'empty_data' => null,
                'attr' => array_merge($disabled, [
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => Gender::class))

            ->add('AdmissionPlanPosition', EntityType::class, array(
                'label' => 'Позиция плана приёма',
                'placeholder' => 'Укажите позицию плана приёма',
                'empty_data' => null,
                'attr' => array_merge($disabled, [
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => AdmissionPlan::class))
            ->add('Region', EntityType::class, array(
                'label' => 'Регион',
                'placeholder' => 'Укажите регион проживания',
                'empty_data' => null,
                'attr' => array_merge($disabled, [
                    'class' => 'form-select',
                ]),
                'required' => false,
                'class' => Regions::class))
            ->add('phone', TextType::class, array(
                'label' => 'Мобильный телефон',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                    'placeholder' => 'Укажите номер мобильного телефона',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('registrationAddress', TextareaType::class, array(
                'label' => 'Адрес регистрации',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                    'placeholder' => 'Укажите Адрес регистрации',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('EducationDocumentName', TextareaType::class, array(
                'label' => 'Документ об образовании',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                    'placeholder' => 'Укажите вид документа об образовании',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('SchoolName', TextareaType::class, array(
                'label' => 'Образовательная организация',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                    'placeholder' => 'Укажите наименование образовательной организации',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('TargetAgreementEmployer', TextareaType::class, array(
                'label' => 'Работодатель',
                'empty_data' => null,
                'required' => false,
                'attr' => array_merge($readOnly, [
                    'placeholder' => 'Укажите наименование организации-работодателя',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('EducationDocumentNumber', TextType::class, array(
                'label' => 'Номер документа',
                'empty_data' => null,
                'required' => false,
                'attr' => array_merge([
                    'placeholder' => 'Введите номер документа',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('Comment', TextareaType::class, array(
                'label' => 'Комментарий',
                'empty_data' => null,
                'required' => false,
                'attr' => array_merge($readOnly, [
                    'placeholder' => '',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('educationDocumentGPA', TextType::class, array(
                'label' => 'Средний балл',
                'empty_data' => null,
                'required' => false,
                'attr' => array_merge($readOnly, [
                    'placeholder' => 'Укажите средний балл',
                    'required' => false,
                    'class' => TextType::class . ' form-control'])
            ))
            ->add('currentLocationAddress', TextareaType::class, array(
                'label' => 'Адрес фактического проживания',
                'empty_data' => null,
                'required' => false,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите Адрес фактического проживания',
                        'class' => TextType::class . ' form-control']
                )))
            ->add('birthPlace', TextType::class, array(
                'label' => 'Место рождения',
                'required' => false,
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите место рождения',

                        'class' => TextType::class . ' form-control']
                )))
            ->add('pasport_issue_organ', TextareaType::class, array(
                'label' => 'Паспорт выдан',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите подразделение',
                        'required' => false,
                        'class' => TextareaType::class . ' form-control']
                )))
            ->add('CancelReason', TextareaType::class, array(
                'required' => false,
                'label' => 'Причина отказа от приема',
                'empty_data' => null,
                'attr' => array_merge($readOnly, [
                        'placeholder' => 'Укажите причину отказа',
                        'required' => false,
                        'class' => TextareaType::class . ' form-control']
                )))
            ->add('status', EntityType::class, [
                'attr' => array_merge([
                    'class' => 'form-select'
                ]),
                'class' => AbiturientPetitionStatus::class])
            ->add('admission', EntityType::class, array(
                'label' => 'Приемная кампания',
                'placeholder' => 'Укажите приемную кампанию',
                'required' => true,
                'empty_data' => null,
                'attr' => array_merge($disabled, [
                    'class' => 'form-select'
                ]),
                'class' => Admission::class))
            ->add('Faculty', EntityType::class, array(
                'label' => 'Специальность',
                'placeholder' => 'Укажите специальность',
                'required' => true,
                'empty_data' => null,
                'attr' => array_merge($disabled, [
                    'class' => 'form-select'
                ]),
                'class' => Faculty::class))
            ->add('canceled', CheckboxType::class, [
                'label' => 'Отозвано ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('IsOrphan', CheckboxType::class, [
                'label' => 'Сирота ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('LockUpdateFormVIS', CheckboxType::class, [
                'label' => 'Блокировка обновления',
                'required' => false,
                'attr' => [
                    'disabled'=>'disabled',
                    'class' => 'form-check-input bg-secondary ',
                    'required' => false,
                ],
            ])
            ->add('IsPoor', CheckboxType::class, [
                'label' => 'Малоимущая семья ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('IsInvalid', CheckboxType::class, [
                'label' => 'Инвалид ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('NeedStudentAccommondation', CheckboxType::class, [
                'label' => 'Нуждается в общежитии ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('CanPay', CheckboxType::class, [
                'label' => 'Может платно ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input ',
                    'required' => false,
                ],
            ])
            ->add('HaveErrorInPetition', CheckboxType::class, [
                'label' => 'В заявлении ошибка ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('loadToFISGIA', CheckboxType::class, [
                'label' => 'Загружено в ФИС ГИА и Приема',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('documentObtained', CheckboxType::class, [
                'label' => 'Сданы оригиналы ',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                    'required' => false,
                ],
            ])
            ->add('HasTargetAgreement', CheckboxType::class, [
                'label' => 'Целевой договор',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input ',
                    'required' => false,
                ],
            ])
            ->add('pasportSeries', TextType::class, array(
                'label' => 'Серия паспорта',
                'empty_data' => null,
                'attr' => array_merge([
                    'required' => false,
                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите серию паспорта',])))
            ->add('pasportNumber', TextType::class, array(
                'label' => 'Номер паспорта',
                'empty_data' => null,
                'attr' => array_merge([
                    'required' => false,
                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите номер паспорта',])))
            ->add('NumberCancel', TextType::class, array(
                'required' => false,
                'label' => 'Номер отказа',
                'empty_data' => null,
                'attr' => array_merge([
                    'required' => false,
                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите номер отказа',])))
            ->add('NumberProvision', TextType::class, array(
                'required' => false,
                'label' => 'Номер решения',
                'empty_data' => null,
                'attr' => array_merge([
                    'required' => false,
                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите номер решения',])))
            ->add('localNumber', TextType::class, array(
                'label' => 'Рег. №',
                'empty_data' => null,
                'attr' => array_merge([
                    'required' => false,
                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите регистрационный номер заявления',])))
            ->add('TargetAgreementNumber', TextType::class, array(
                'label' => 'Номер договора',
                'empty_data' => null,
                'required' => false,
                'attr' => array_merge([
                    'required' => false,
                    'class' => TextType::class . ' form-control',
                    'placeholder' => 'Укажите номер целевого договора',])))


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbiturientPetition::class,
            'status' => AbiturientPetitionStatus::class
        ]);
    }
}
