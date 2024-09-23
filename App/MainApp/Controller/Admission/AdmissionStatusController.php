<?php

namespace App\MainApp\Controller\Admission;

use App\Controller\App\Admission\IsGranted;
use App\MainApp\Entity\AdmissionStatus;
use App\MainApp\Form\AdmissionStatusType;
use App\MainApp\Repository\AdmissionStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/priem/admission-status')]
#[IsGranted("ROLE_USER")]
class AdmissionStatusController extends AbstractController
{
    #[Route('/', name: 'app_admission_status_index', methods: ['GET'])]
    public function index(AdmissionStatusRepository $admissionStatusRepository): Response
    {
        return $this->render('admission_status/index.html.twig', [
            'admission_statuses' => $admissionStatusRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admission_status_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AdmissionStatusRepository $admissionStatusRepository): Response
    {
        $admissionStatus = new AdmissionStatus();
        $form = $this->createForm(AdmissionStatusType::class, $admissionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionStatusRepository->save($admissionStatus, true);

            return $this->redirectToRoute('app_admission_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_status/new.html.twig', [
            'admission_status' => $admissionStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admission_status_show', methods: ['GET'])]
    public function show(AdmissionStatus $admissionStatus): Response
    {
        return $this->render('admission_status/show.html.twig', [
            'admission_status' => $admissionStatus,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admission_status_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdmissionStatus $admissionStatus, AdmissionStatusRepository $admissionStatusRepository): Response
    {
        $form = $this->createForm(AdmissionStatusType::class, $admissionStatus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionStatusRepository->save($admissionStatus, true);

            return $this->redirectToRoute('app_admission_status_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_status/edit.html.twig', [
            'admission_status' => $admissionStatus,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admission_status_delete', methods: ['POST'])]
    public function delete(Request $request, AdmissionStatus $admissionStatus, AdmissionStatusRepository $admissionStatusRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admissionStatus->getId(), $request->request->get('_token'))) {
            $admissionStatusRepository->remove($admissionStatus, true);
        }

        return $this->redirectToRoute('app_admission_status_index', [], Response::HTTP_SEE_OTHER);
    }
}
