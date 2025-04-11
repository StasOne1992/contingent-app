<?php

namespace App\mod_admission\Controller;

use App\mod_admission\Entity\Admission;
use App\mod_admission\Form\AdmissionType;
use App\mod_admission\Repository\AdmissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/admissions')]
#[IsGranted("ROLE_USER")]
class AdmissionController extends AbstractController
{
    #[Route('/', name: 'app_admission_index', methods: ['GET'])]
    #[IsGranted('ROLE_STAFF_ADMISSION_R')]
    public function index(AdmissionRepository $admissionRepository): Response
    {
        return $this->render('@mod_admission/admission/index.html.twig', [
            'admissions' => $admissionRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_admission_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STAFF_ADMISSION_C')]
    public function new(Request $request, AdmissionRepository $admissionRepository): Response
    {
        $admission = new Admission();
        $form = $this->createForm(AdmissionType::class, $admission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionRepository->save($admission, true);

            return $this->redirectToRoute('app_admission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@mod_admission/admission/new.html.twig', [
            'admission' => $admission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admission_show', methods: ['GET'])]
    #[IsGranted('ROLE_STAFF_ADMISSION_R')]
    public function show(Admission $admission): Response
    {
        return $this->render('@mod_admission/admission/show.html.twig', [
            'admission' => $admission,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admission_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STAFF_ADMISSION_U')]
    public function edit(Request $request, Admission $admission, AdmissionRepository $admissionRepository): Response
    {
        $form = $this->createForm(AdmissionType::class, $admission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionRepository->save($admission, true);

            return $this->redirectToRoute('app_admission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@mod_admission/admission/edit.html.twig', [
            'admission' => $admission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admission_delete', methods: ['POST'])]
    #[IsGranted('ROLE_STAFF_ADMISSION_D')]
    public function delete(Request $request, Admission $admission, AdmissionRepository $admissionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $admission->getId(), $request->request->get('_token'))) {
            $admissionRepository->remove($admission, true);
        }

        return $this->redirectToRoute('app_admission_index', [], Response::HTTP_SEE_OTHER);
    }
}
