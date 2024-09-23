<?php

namespace App\MainApp\Controller\Admission;

use App\Controller\App\Admission\IsGranted;
use App\MainApp\Entity\AdmissionPlan;
use App\MainApp\Form\AdmissionPlanType;
use App\MainApp\Repository\AdmissionPlanRepository;
use App\MainApp\Service\TypicalDocuments;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/plan')]
#[IsGranted("ROLE_USER")]
class AdmissionPlanController extends AbstractController
{
    #[Route('/', name: 'app_admission_plan_index', methods: ['GET'])]
    public function index(AdmissionPlanRepository $admissionPlanRepository): Response
    {
        return $this->render('admission_plan/index.html.twig', [
            'admission_plans' => $admissionPlanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admission_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AdmissionPlanRepository $admissionPlanRepository): Response
    {
        $admissionPlan = new AdmissionPlan();
        $form = $this->createForm(AdmissionPlanType::class, $admissionPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionPlanRepository->save($admissionPlan, true);

            return $this->redirectToRoute('app_admission_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_plan/new.html.twig', [
            'admission_plan' => $admissionPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admission_plan_show', methods: ['GET'])]
    public function show(AdmissionPlan $admissionPlan): Response
    {
        return $this->render('admission_plan/show.html.twig', [
            'admission_plan' => $admissionPlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admission_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AdmissionPlan $admissionPlan, AdmissionPlanRepository $admissionPlanRepository): Response
    {
        $form = $this->createForm(AdmissionPlanType::class, $admissionPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionPlanRepository->save($admissionPlan, true);

            return $this->redirectToRoute('app_admission_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission_plan/edit.html.twig', [
            'admission_plan' => $admissionPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admission_plan_delete', methods: ['POST'])]
    public function delete(Request $request, AdmissionPlan $admissionPlan, AdmissionPlanRepository $admissionPlanRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $admissionPlan->getId(), $request->request->get('_token'))) {
            $admissionPlanRepository->remove($admissionPlan, true);
        }

        return $this->redirectToRoute('app_admission_plan_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/examination_result', name: 'app_admission_plan_examination_result', methods: ['GET'])]
    public function examination_result(AdmissionPlan $admissionPlan, TypicalDocuments $typicalDocuments): Response
    {

        $html =  $this->renderView('_printtemplate.html.twig',
            [
                'content' => $typicalDocuments->generateAdmissionExaminationResultReport($admissionPlan)
            ]);
        $options = new Options();
        $options->set('defaultFont', '');

        $dompdf = new Dompdf($options);
        $options = $dompdf->getOptions();
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();

        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );

    }

}
