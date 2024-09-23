<?php

namespace App\MainApp\Controller\Admission\Examination;

use App\Controller\App\Admission\Examination\IsGranted;
use App\MainApp\Entity\AdmissionExaminationSubjects;
use App\MainApp\Form\AdmissionExaminationSubjectsType;
use App\MainApp\Repository\AdmissionExaminationSubjectsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/examination/subjects')]
#[IsGranted("ROLE_USER")]
class AdmissionExaminationSubjectsController extends AbstractController
{
    #[Route('/', name: 'app_admission_examination_subjects_index', methods: ['GET'])]
    public function index(AdmissionExaminationSubjectsRepository $admissionExaminationSubjectsRepository): Response
    {
        return $this->render('admission_examination_subjects/index.html.twig', [
            'admission_examination_subjects' => $admissionExaminationSubjectsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admission_examination_subjects_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admissionExaminationSubject = new AdmissionExaminationSubjects();
        $form = $this->createForm(AdmissionExaminationSubjectsType::class, $admissionExaminationSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($admissionExaminationSubject);
            $entityManager->flush();

            return $this->redirectToRoute('app_admission_examination_subjects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_examination_subjects/new.html.twig', [
            'admission_examination_subject' => $admissionExaminationSubject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admission_examination_subjects_show', methods: ['GET'])]
    public function show(AdmissionExaminationSubjects $admissionExaminationSubject): Response
    {
        return $this->render('admission_examination_subjects/show.html.twig', [
            'admission_examination_subject' => $admissionExaminationSubject,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admission_examination_subjects_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdmissionExaminationSubjects $admissionExaminationSubject, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdmissionExaminationSubjectsType::class, $admissionExaminationSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admission_examination_subjects_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_examination_subjects/edit.html.twig', [
            'admission_examination_subject' => $admissionExaminationSubject,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admission_examination_subjects_delete', methods: ['POST'])]
    public function delete(Request $request, AdmissionExaminationSubjects $admissionExaminationSubject, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admissionExaminationSubject->getId(), $request->request->get('_token'))) {
            $entityManager->remove($admissionExaminationSubject);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admission_examination_subjects_index', [], Response::HTTP_SEE_OTHER);
    }
}
