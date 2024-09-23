<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\AdmissionExaminationResult;
use App\MainApp\Form\AdmissionExaminationResultType;
use App\MainApp\Repository\AdmissionExaminationResultRepository;
use App\Controller\App\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/examination/result')]
#[IsGranted("ROLE_USER")]
class AdmissionExaminationResultController extends AbstractController
{
    #[Route('/', name: 'app_admission_examination_result_index', methods: ['GET'])]
    public function index(AdmissionExaminationResultRepository $admissionExaminationResultRepository): Response
    {
        return $this->render('admission_examination_result/index.html.twig', [
            'admission_examination_results' => $admissionExaminationResultRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admission_examination_result_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admissionExaminationResult = new AdmissionExaminationResult();
        $form = $this->createForm(AdmissionExaminationResultType::class, $admissionExaminationResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($admissionExaminationResult);
            $entityManager->flush();

            return $this->redirectToRoute('app_admission_examination_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_examination_result/new.html.twig', [
            'admission_examination_result' => $admissionExaminationResult,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admission_examination_result_show', methods: ['GET'])]
    public function show(AdmissionExaminationResult $admissionExaminationResult): Response
    {
        return $this->render('admission_examination_result/show.html.twig', [
            'admission_examination_result' => $admissionExaminationResult,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admission_examination_result_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdmissionExaminationResult $admissionExaminationResult, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdmissionExaminationResultType::class, $admissionExaminationResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admission_examination_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_examination_result/edit.html.twig', [
            'admission_examination_result' => $admissionExaminationResult,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admission_examination_result_delete', methods: ['POST'])]
    public function delete(Request $request, AdmissionExaminationResult $admissionExaminationResult, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admissionExaminationResult->getId(), $request->request->get('_token'))) {
            $entityManager->remove($admissionExaminationResult);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admission_examination_result_index', [], Response::HTTP_SEE_OTHER);
    }
}
