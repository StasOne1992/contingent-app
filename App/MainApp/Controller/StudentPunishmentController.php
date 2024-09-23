<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\StudentPunishment;
use App\MainApp\Form\StudentPunishmentType;
use App\MainApp\Repository\StudentPunishmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/student/punishment')]
class StudentPunishmentController extends AbstractController
{
    #[Route('/index', name: 'app_student_punishment_index', methods: ['GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_PUNISHMENT_R')]
    public function index(StudentPunishmentRepository $studentPunishmentRepository): Response
    {
        return $this->render('student_punishment/index.html.twig', [
            'student_punishments' => $studentPunishmentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_student_punishment_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STAFF_STUDENT_PUNISHMENT_C')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $studentPunishment = new StudentPunishment();
        $form = $this->createForm(StudentPunishmentType::class, $studentPunishment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($studentPunishment);
            $entityManager->flush();

            return $this->redirectToRoute('app_student_punishment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_punishment/new.html.twig', [
            'student_punishment' => $studentPunishment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_student_punishment_show', methods: ['GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_PUNISHMENT_R')]
    public function show(StudentPunishment $studentPunishment): Response
    {
        return $this->render('student_punishment/show.html.twig', [
            'student_punishment' => $studentPunishment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_punishment_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STAFF_STUDENT_PUNISHMENT_U')]
    public function edit(Request $request, StudentPunishment $studentPunishment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudentPunishmentType::class, $studentPunishment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_student_punishment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_punishment/edit.html.twig', [
            'student_punishment' => $studentPunishment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_student_punishment_delete', methods: ['POST'])]
    #[IsGranted('ROLE_STAFF_STUDENT_PUNISHMENT_D')]
    public function delete(Request $request, StudentPunishment $studentPunishment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$studentPunishment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($studentPunishment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_student_punishment_index', [], Response::HTTP_SEE_OTHER);
    }
}
