<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\EducationPlan;
use App\MainApp\Form\EducationPlanType;
use App\MainApp\Repository\EducationPlanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/education/plan')]
#[IsGranted("ROLE_USER")]
class EducationPlanController extends AbstractController
{
    #[Route('/', name: 'app_education_plan_index', methods: ['GET'])]
    public function index(EducationPlanRepository $educationPlanRepository): Response
    {
        return $this->render('education_plan/index.html.twig', [
            'education_plans' => $educationPlanRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_education_plan_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $educationPlan = new EducationPlan();
        $form = $this->createForm(EducationPlanType::class, $educationPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($educationPlan);
            $entityManager->flush();

            return $this->redirectToRoute('app_education_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('education_plan/new.html.twig', [
            'education_plan' => $educationPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_education_plan_show', methods: ['GET'])]
    public function show(EducationPlan $educationPlan): Response
    {
        return $this->render('education_plan/show.html.twig', [
            'education_plan' => $educationPlan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_education_plan_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EducationPlan $educationPlan, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EducationPlanType::class, $educationPlan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_education_plan_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('education_plan/edit.html.twig', [
            'education_plan' => $educationPlan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_education_plan_delete', methods: ['POST'])]
    public function delete(Request $request, EducationPlan $educationPlan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$educationPlan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($educationPlan);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_education_plan_index', [], Response::HTTP_SEE_OTHER);
    }
}
