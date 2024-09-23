<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\EventsResultTypes;
use App\MainApp\Form\EventsResultTypesType;
use App\MainApp\Repository\EventsResultTypesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/events/result/types')]
class EventsResultTypesController extends AbstractController
{
    #[Route('/', name: 'app_events_result_types_index', methods: ['GET'])]
    public function index(EventsResultTypesRepository $eventsResultTypesRepository): Response
    {
        return $this->render('events_result_types/index.html.twig', [
            'events_result_types' => $eventsResultTypesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_events_result_types_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventsResultType = new EventsResultTypes();
        $form = $this->createForm(EventsResultTypesType::class, $eventsResultType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventsResultType);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_result_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_result_types/new.html.twig', [
            'events_result_type' => $eventsResultType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_result_types_show', methods: ['GET'])]
    public function show(EventsResultTypes $eventsResultType): Response
    {
        return $this->render('events_result_types/show.html.twig', [
            'events_result_type' => $eventsResultType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_events_result_types_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventsResultTypes $eventsResultType, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsResultTypesType::class, $eventsResultType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_result_types_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_result_types/edit.html.twig', [
            'events_result_type' => $eventsResultType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_result_types_delete', methods: ['POST'])]
    public function delete(Request $request, EventsResultTypes $eventsResultType, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsResultType->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventsResultType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_events_result_types_index', [], Response::HTTP_SEE_OTHER);
    }
}
