<?php

namespace App\MainApp\Service;

use App\MainApp\Entity\Student;
use App\MainApp\Entity\StudentGroups;
use App\MainApp\Repository\StudentRepository;
use App\MainApp\Repository\UserRepository;


class StudentService
{

    public function __construct(
        private StudentRepository $studentRepository,
        private UserRepository    $userRepository,
    )
    {
    }


    public function fillStudentsUUID()
    {

        $studentsList = $this->studentRepository->findBy(['UUID' => null]);
        foreach ($studentsList as $student) {
            $this->setStudentUUID($student);
        }
    }

    /**
     * @param Student $student
     * @return void
     */
    public function setStudentUUID($student): void
    {
        $student->setUUID(uniqid());
        $this->studentRepository->save($student, true);
    }


    public function fillStudentsEmails()
    {
        $studentsList = $this->studentRepository->findBy(['email' => null]);
        foreach ($studentsList as $student) {
            $this->setStudentEmailByUser($student);
        }
    }

    /**
     * @param Student $student
     * @return void
     */
    public function setStudentEmailByUser($student): void
    {
        $user = $this->userRepository->findOneBy(['Student' => $student->getId()]);
        if ($user != null) {
            if ($user->getEmail() != null) {
                $student->setEmail($user->getEmail());
                $this->studentRepository->save($student, true);
            }
        }
    }

    public function getEmptyGroup(): StudentGroups
    {
        $group = new StudentGroups();
        $group->setName("Группа не указана");
        $group->setCode("EMPTY");
        //$group->setLetter("EMP");
        return $group;
    }

    public function getEmptyStudent(): Student
    {
        $student = new Student();
        $student->setStudentGroup($this->getEmptyGroup());
        $student->setGender(null);
        $student->setFirstName("Иван");
        $student->setLastName("Иванов");
        $student->setMiddleName("Иванович");
        $student->setEmail("ivanovii@test.email.lan");
        $student->setUUID(uniqid());
        $student->setPhoneNumber("81234567890");
        $student->setPasportSeries("0000");
        $student->setPhoneNumber("112233");
        $timestamp = mt_rand(1, time());
        $randomDate = new \DateTime(date("d M Y", $timestamp));
        $student->setBirthDate($randomDate);
        $student->setIsActive(true);
        return $student;
    }

    public function getStudentByUserId(?Student $student): Student
    {
        if ($student == null) {
            return $this->getEmptyStudent();
        }
        return $student;
    }
}