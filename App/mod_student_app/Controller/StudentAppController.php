<?php

namespace App\mod_student_app\Controller;

use App\MainApp\Entity\Student;
use App\StudentApp\Form\StudentProfile;
use App\MainApp\Repository\StudentRepository;
use App\MainApp\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/student-app')]
#[IsGranted("ROLE_USER")]
class StudentAppController extends AbstractController
{
    private Student $Student;
    private StudentRepository $studentRepository;
    private StudentService $studentService;

    public function __construct(
        StudentRepository $studentRepository,
        StudentService    $studentService,
    )
    {
        $this->studentService = $studentService;
        $this->studentRepository = $studentRepository;
    }



    #[Route('/', name: 'app_student_dashboard', methods: ['GET'])]
    public function dashboad(StudentRepository $studentRepository): Response
    {
        $this->Student=$this->studentService->getStudentByUserId($this->getUser()->getStudent());

        return $this->render('@mod_student_app/dashboard/dashboard.html.twig',
                [
                    'student' => $this->Student
                ]);
    }

    #[Route('/profile', name: 'app_student_profile', methods: ['GET'])]
    public function profile(StudentRepository $studentRepository): Response
    {
        $currentUser = $this->getUser()->getStudentProfileID();
        if ($currentUser != 0) {
            return $this->render('student-app/profile.html.twig',
                [
                    'student' => $studentRepository->findOneBy(array('id' => $currentUser)),

                ]);
        } else {
            return $this->render('student-app/error.html.twig');
        }


    }
}