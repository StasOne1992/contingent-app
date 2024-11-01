<?php

namespace App\DataFixtures;

use App\MainApp\Entity\College;
use App\MainApp\Entity\Gender;
use App\MainApp\Entity\Staff;
use App\MainApp\Entity\User;
use App\mod_admission\Entity\AbiturientPetitionStatus;
use App\mod_education\Entity\ContingentDocumentType;
use App\mod_education\Entity\EducationForm;
use App\mod_education\Entity\EducationType;
use App\mod_education\Entity\FamilyTypeList;
use App\mod_education\Entity\FinancialType;
use App\mod_education\Entity\StudentGroups;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;


    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        UserPasswordHasherInterface $userPasswordHasher,
        private HttpClientInterface $client,
    )
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $college = new College();
        $college->setname("demo college");
        $college->setEmail("college@example.com");
        $college->setShortName("college");
        $college->setPostalAddress("Почтовый адрес");
        $college->setregisteredAddress("г.Москва");
        $college->setWebSite("www.ru");
        $college->setLogo("logo.png");
        $college->setPhone("+71231112233");
        $college->setFax("+71231112233");
        $college->setSettingsStaffDomain("staff.example.com");
        $college->setSettingsStudentsDomain("stud.example.com");
        $manager->persist($college);

        /**
         * Заполнение справочника Gender
         */

        $GenderList = array(
            array("муж.", "MALE"),
            array("жен.", "FEMALE"));
        foreach ($GenderList as $item) {
            $gender = new Gender();
            $gender->setName($item["0"]);
            $gender->setGenderName($item[1]);
            $manager->persist($gender);
        }


        /**
         * Заполнение справочника FinancialType
         */

        $financialTypeList = array(
            array("BUDGET", "Бюджет"),
            array("CONTRACT", "Внебюджет"),
            array("TARGETED", "Целевое обучение"));

        foreach ($financialTypeList as $type) {
            $FinancialType = new FinancialType();
            $FinancialType->setName($type[0]);
            $FinancialType->setTitle($type[1]);
            $manager->persist($FinancialType);
        }
        /**
         *  Заполнение справочника FamilyTypeList
         */
        $familyTypeList = array("Полная семья", "Неполная семья", "Проживает с опекуном", "Имеет свою семью");

        foreach ($familyTypeList as $familyType) {
            $familyTypeObject = new FamilyTypeList();
            $familyTypeObject->setName($familyType);
            $manager->persist($familyTypeObject);
        }


        $contingentDocumentTypeList
            = array(
            array("Приказ о зачислении на 1 курс", "ENROLFIRST"),
            array("Приказ об отчислении", "DISMISS"),
            array("Приказ о зачислении", "ENROLL"),
            array("Приказ о переводе", "TRANSLATE"));
        foreach ($contingentDocumentTypeList as $item) {
            $contingentDocumentType = new ContingentDocumentType();
            $contingentDocumentType->setName($item[0]);
            $contingentDocumentType->setTitle($item[1]);
        }

        $educationFormList = array(
            array("EXTRAMURAL", "Заочная"),
            array("PART_TIME", "заочная"),
            array("FULL_TIME", "Очная")
        );
        foreach ($educationFormList as $item) {
            $educationForm = new EducationForm();
            $educationForm->setName($item[0]);
            $educationForm->setTitle($item[1]);
            $manager->persist($educationForm);
        }


        $educationTypeList = array(
            array("SPO", "Среднее профессиональное образование"),
            array("VPO","Высшее образование – бакалавриат"),
            array("VPO2","Высшее образование – специалитет "),
            array("VPO3","Высшее образование – магистратура "),
            array("SECONDARY","Среднее общее (полное) образование"),
            array("BASIC","Основное общее образование"));
        foreach ($educationTypeList as $item) {
            $educationType=new EducationType();
            $educationType->setName($item[0]);
            $educationType->setTitle($item[1]);
            $manager->persist($educationType);
        }
        
        
        $abiturientPetitionStatusList = array(array("Зарегистрировано", "REGISTERED"),
            array("Отклонено", "REJECTED"),
            array("Принято к рассмотрению", "ACCEPTED"),
            array("Проверка сведений", "CHECK"),
            array("Рекомендован", "RECOMMENDED"),
            array("Сдал оригиналы", "DOCUMENTS_OBTAINED"),
            array("Зачислено", "INDUCTED"));
        foreach ($abiturientPetitionStatusList as $status) {
            $PetitionStatus = new AbiturientPetitionStatus();
            $PetitionStatus->setTitle($status[0]);
            $PetitionStatus->setName($status[1]);
            $manager->persist($PetitionStatus);
        }


        /**
         * Создание сотрудника
         */
        $staff_admin=new Staff();
        $staff_admin->setFirstName("Administrator");
        $staff_admin->setLastName("LastName");
        $staff_admin->setMiddleName('');
        $staff_admin->setEmail("administrator@example.com");
        $staff_admin->addCollege($college);
        $manager->persist($staff_admin);


        /*$faculty = new Faculty();
        $manager->persist($faculty);*/


        $studentGroup = new StudentGroups();
        $studentGroup->setGroupLeader($staff_admin);
        $studentGroup->setCourseNumber(1);
        $studentGroup->setParallelNumber(1);
        $manager->persist($studentGroup);


        $user = new User();
        $user->setCollege($college);
        $user->setEmail($staff_admin->getEmail());
        $plaintextPassword = "changeme";
        $hashedPassword = $this->userPasswordHasher->hashPassword($user,$plaintextPassword);
        $user->setPassword($hashedPassword);
        $user->setIsStudent(false);
        $user->setRoles(array("ROLE_ROOT"));
        $manager->persist($user);


        $manager->flush();
    }


}