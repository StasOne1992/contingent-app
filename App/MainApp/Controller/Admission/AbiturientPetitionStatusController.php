<?php

namespace App\MainApp\Controller\Admission;

use App\Controller\App\Admission\IsGranted;
use App\MainApp\Entity\AbiturientPetitionStatus;
use App\MainApp\Form\AbiturientPetitionStatusType;
use App\MainApp\Repository\AbiturientPetitionStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/petition/status')]
#[IsGranted("ROLE_USER")]
class AbiturientPetitionStatusController extends AbstractController
{
    #[Route('/', name: 'app_abiturient_petition_status_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_SUBJECT_R")]
    public function index(AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository): Response
    {
        return $this->render('abiturient_petition_status/index.html.twig', [
            'abiturient_petition_statuses' => $abiturientPetitionStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_abiturient_petition_status_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_SUBJECT_C")]
    public function new(Request $request, AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository): Response
    {
        $abiturientPetitionStatus = new AbiturientPetitionStatus();
        $form = $this->createForm(AbiturientPetitionStatusType::class, $abiturientPetitionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abiturientPetitionStatusRepository->save($abiturientPetitionStatus, true);

            return $this->redirectToRoute('app_abiturient_petition_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('abiturient_petition_status/new.html.twig', [
            'abiturient_petition_status' => $abiturientPetitionStatus,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/show', name: 'app_abiturient_petition_status_show', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_SUBJECT_R")]
    public function show(AbiturientPetitionStatus $abiturientPetitionStatus): Response
    {
        return $this->render('abiturient_petition_status/show.html.twig', [
            'abiturient_petition_status' => $abiturientPetitionStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_abiturient_petition_status_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_SUBJECT_U")]
    public function edit(Request $request, AbiturientPetitionStatus $abiturientPetitionStatus, AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository): Response
    {
        $form = $this->createForm(AbiturientPetitionStatusType::class, $abiturientPetitionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abiturientPetitionStatusRepository->save($abiturientPetitionStatus, true);

            return $this->redirectToRoute('app_abiturient_petition_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('abiturient_petition_status/edit.html.twig', [
            'abiturient_petition_status' => $abiturientPetitionStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_abiturient_petition_status_delete', methods: ['POST'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_SUBJECT_D")]
    public function delete(Request $request, AbiturientPetitionStatus $abiturientPetitionStatus, AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abiturientPetitionStatus->getId(), $request->request->get('_token'))) {
            $abiturientPetitionStatusRepository->remove($abiturientPetitionStatus, true);
        }

        return $this->redirectToRoute('app_abiturient_petition_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
