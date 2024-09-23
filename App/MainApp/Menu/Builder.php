<?php

namespace App\MainApp\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;


class Builder
{
    private $factory;

    /**
     * Add any other dependency you n eed...
     */
    public function __construct(FactoryInterface $factory, private AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->factory = $factory;
    }

    public function mainMenu(array $options): ItemInterface
    {

        $menu = $this->factory->createItem('root');
        $menu->addChild('Личный кабинет', ['route' => 'app_dashboard_index']);
        if ($this->authorizationChecker->isGranted('ROLE_STAFF_AB_PETITIONS_R')) {
            $menu->addChild('Приемная комиссия', ['attributes' => ['class' => 'nav-main-heading']]);
            $menu->addChild('Панель управления', ['route' => 'app_admission_dashboard_index']);
            $priem = $menu->addChild('Абитуриенты', ['uri' => '/', 'attributes' => ['dropdown' => true]]);
            $priem->addChild('Заявления', ['route' => 'app_abiturient_petition_index']);
            if ($this->authorizationChecker->isGranted('ROLE_STAFF_AB_PETITIONS_FULL')) {
                $admission = $menu->addChild('Приемная кампания', ['uri' => '/', 'attributes' => ['dropdown' => true]]);
                $admission->addChild('Приемные кампании', ['route' => 'app_admission_index']);
                $admission->addChild('Конкурсы', ['route' => 'app_admission_plan_index']);
            }
            $admissionExamination = $menu->addChild('Вступительные испытания', ['uri' => '#', 'attributes' => ['dropdown' => true]]);
            $admissionExamination->addChild('Испытания', ['route' => 'app_admission_examination_index']);
            $admissionExamination->addChild('Дисциплины', ['route' => 'app_admission_examination_subjects_index']);
            $admission_reports = $menu->addChild('Отчёты по ПК', ['uri' => '/', 'attributes' => ['dropdown' => true]]);
            $admission_reports->addChild('Выполнение плана', ['route' => 'app_abiturient_petition_index']);
        }
        if ($this->authorizationChecker->isGranted('ROLE_STAFF_STUDENT_R')) {
            if (($this->authorizationChecker->isGranted('ROLE_STAFF_STUDENT_R')
                and !($this->authorizationChecker->isGranted('ROLE_CL')))) {
                $menu->addChild('Учебная часть', ['attributes' => ['class' => 'nav-main-heading']]);
            } elseif ($this->authorizationChecker->isGranted('ROLE_CL')) {
                $menu->addChild('Контингент', ['attributes' => ['class' => 'nav-main-heading']]);
            }
            if ($this->authorizationChecker->isGranted('ROLE_STAFF_STUDENT_R')) {
                $student = $menu->addChild('Студенты', ['uri' => '/', 'attributes' => ['dropdown' => true]]);
                $student->addChild('Список студентов', ['route' => 'app_student_index']);
                if ($this->authorizationChecker->isGranted('ROLE_STAFF_STUDENT_C')) {
                    $student->addChild('Добавить студента', ['route' => 'app_student_new']);
                }
            }
            if ($this->authorizationChecker->isGranted('ROLE_STAFF_CONT_DOC_R')) {
                $decree = $menu->addChild('Документы', ['uri' => '#', 'attributes' => ['dropdown' => true]]);
                $decree->addChild('Приказы о движении', ['route' => 'app_contingent_document_index']);
            }
            if ($this->authorizationChecker->isGranted('ROLE_STAFF_CONT_DOC_R')) {
                $menu->addChild('Студенческие группы', ['route' => 'app_student_groups_index']);
                $education = $menu->addChild('Образование', ['uri' => '#', 'attributes' => ['dropdown' => true]]);
                $education->addChild('Учебные планы', ['route' => 'app_education_plan_index']);
                $education->addChild('Дисциплины', ['route' => 'app_education_subjects_index']);
            }
        }
        if ($this->authorizationChecker->isGranted('ROLE_ROOT')) {
            $menu->addChild("ПОО", ['attributes' => ['class' => 'nav-main-heading']]);
            $college = $menu->addChild('Образовательная организация', ['route' => 'app_college_index']);
        }
        if ($this->authorizationChecker->isGranted('ROLE_ROOT')) {
            $menu->addChild('Администрирование', ['attributes' => ['class' => 'nav-main-heading']]);
            $users = $menu->addChild('Пользователи', ['route' => 'app_user_index', 'attributes' => ['dropdown' => true]]);
            $users->addChild('Список пользователей', ['route' => 'app_user_index']);
            $users->addchild('Добавить', ['route' => 'app_user_new']);
            $users->addchild('Дейсвия пользователей', ['uri' => '#']);
            $users->addchild('Роли пользователей', ['uri' => '#']);
            $directories = $menu->addChild('Справочники', ['attributes' => ['dropdown' => true]]);
            $directories->addChild('Справочник. Виды законных представителей', ['route' => 'app_legal_representative_type_list_index']);
            $directories->addchild('Справочник. Виды семей', ['route' => 'app_family_type_list_index']);
            $directories->addchild('Дейсвия пользователей', ['uri' => '#']);
            $directories->addchild('Роли пользователей', ['uri' => '#']);
            $staff = $menu->addChild('Сотрудники', ['route' => 'app_staff_index', 'attributes' => ['dropdown' => true]]);
            $staff->addChild('Список сотрудников', ['route' => 'app_staff_index']);
            $staff->addchild('Добавить', ['route' => 'app_staff_new']);
            $staff->addchild('Действия пользователей', ['uri' => '#']);
            $staff->addchild('Роли пользователей', ['uri' => '#']);
            $system = $menu->addChild('Система', ['uri' => '#', 'attributes' => ['dropdown' => true]]);
            $system->addChild('Системные сервисы', ['route' => 'app_system_services_index']);
        }
        if ($this->authorizationChecker->isGranted('ROLE_STUDENT')) {
            $menu->addChild('Перейти в профиль студента', ['route' => 'app_student_dashboard', 'attributes' => ['class' => 'mt-6  ']]);
        }
        return $menu;
    }


    public function studentAppMainMenu(FactoryInterface $factory, array $options): ItemInterface
    {
        $menu = $factory->createItem('root');
        return $menu;
    }

}