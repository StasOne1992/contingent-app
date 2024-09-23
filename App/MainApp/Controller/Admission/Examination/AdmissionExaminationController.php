<?php

namespace App\MainApp\Controller\Admission\Examination;

use App\Controller\App\Admission\Examination\IsGranted;
use App\MainApp\Entity\AdmissionExamination;
use App\MainApp\Form\AdmissionExaminationType;
use App\MainApp\Repository\AbiturientPetitionRepository;
use App\MainApp\Repository\AdmissionExaminationRepository;
use App\MainApp\Service\Admission\AdmissionExaminationPreparationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/examination')]
#[IsGranted("ROLE_USER")]
class AdmissionExaminationController extends AbstractController
{
    /**
     *
     * @param AbiturientPetitionRepository $abiturientPetitionRepository
     * @param AdmissionExaminationPreparationService $admissionExaminationPreparationService
     */
    public function __construct(
        private AbiturientPetitionRepository $abiturientPetitionRepository,
        private AdmissionExaminationPreparationService $admissionExaminationPreparationService,
    )
    {
    }

    #[Route('/', name: 'app_admission_examination_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_R")]
    public function index(AdmissionExaminationRepository $admissionExaminationRepository): Response
    {
        return $this->render('admission_examination/index.html.twig', [
            'admission_examinations' => $admissionExaminationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admission_examination_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_C")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admissionExamination = new AdmissionExamination();
        $form = $this->createForm(AdmissionExaminationType::class, $admissionExamination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($admissionExamination);
            $entityManager->flush();

            return $this->redirectToRoute('app_admission_examination_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_examination/new.html.twig', [
            'admission_examination' => $admissionExamination,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admission_examination_show', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_R")]
    public function show(AdmissionExamination $admissionExamination): Response
    {
        return $this->render('admission_examination/show.html.twig', [
            'admission_examination' => $admissionExamination,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admission_examination_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_U")]
    public function edit(Request $request, AdmissionExamination $admissionExamination, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdmissionExaminationType::class, $admissionExamination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admission_examination_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_examination/edit.html.twig', [
            'admission_examination' => $admissionExamination,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/preparation', name: 'app_admission_examination_preparation', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_ADMISSION_EXAMINATION_P,ROLE_STAFF_AB_PETITIONS_U")]
    public function preparation(Request $request, AdmissionExamination $admissionExamination, EntityManagerInterface $entityManager): Response
    {
        $admissionExaminationListToCreate=array();
        $this->admissionExaminationPreparationService->AdmissionExaminationPreparationPrepare($this->abiturientPetitionRepository->findBy(['AdmissionPlanPosition'=>$admissionExamination->getAdmissionPlanPosition()]),$admissionExamination);

        $form = $this->createForm(AdmissionExaminationType::class, $admissionExamination);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_admission_examination_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('admission_examination/edit.html.twig', [
            'admission_examination' => $admissionExamination,
            'admission_examination_list_create' => $admissionExaminationListToCreate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admission_examination_delete', methods: ['POST'])]
    public function delete(Request $request, AdmissionExamination $admissionExamination, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admissionExamination->getId(), $request->request->get('_token'))) {
            $entityManager->remove($admissionExamination);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admission_examination_index', [], Response::HTTP_SEE_OTHER);
    }
}
