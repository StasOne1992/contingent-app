<?php

namespace App\mod_admission\Controller;

use App\Controller\App\Admission\IsGranted;
use App\mod_admission\Entity\AdmissionExaminationResult;
use App\mod_admission\Form\AdmissionExaminationResultType;
use App\mod_admission\Repository\AbiturientPetitionRepository;
use App\mod_admission\Repository\AdmissionExaminationResultRepository;
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
    public function __construct(
        private AbiturientPetitionRepository $abiturientPetitionRepository,
    )
    {

    }

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


    #[Route('/new/abiturient-{abiturientPetitionId}', name: 'app_admission_examination_result_new_for_abiturient_petition', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_AB_PETITIONS_C")]
    public function newForAbiturientPetition(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admissionExaminationResult = new AdmissionExaminationResult();
        $AbiturientPetition=$this->abiturientPetitionRepository->find($request->get('abiturientPetitionId'));
        $admissionExaminationResult->setAbiturientPetition($AbiturientPetition);
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



    #[Route('/{id}/show', name: 'app_admission_examination_result_show', methods: ['GET'])]
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



    #[Route('/{id}/delete', name: 'app_admission_examination_result_delete', methods: ['POST'])]
    public function delete(Request $request, AdmissionExaminationResult $admissionExaminationResult, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admissionExaminationResult->getId(), $request->request->get('_token'))) {
            $entityManager->remove($admissionExaminationResult);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admission_examination_result_index', [], Response::HTTP_SEE_OTHER);
    }
}
