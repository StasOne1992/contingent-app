<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\EventsPlaces;
use App\MainApp\Form\EventsPlacesType;
use App\MainApp\Repository\EventsPlacesRepository;
use App\Controller\App\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/events/places')]
#[IsGranted("ROLE_USER")]
class EventsPlacesController extends AbstractController
{
    #[Route('/', name: 'app_events_places_index', methods: ['GET'])]
    public function index(EventsPlacesRepository $eventsPlacesRepository): Response
    {
        return $this->render('events_places/index.html.twig', [
            'events_places' => $eventsPlacesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_events_places_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventsPlace = new EventsPlaces();
        $form = $this->createForm(EventsPlacesType::class, $eventsPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventsPlace);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_places_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_places/new.html.twig', [
            'events_place' => $eventsPlace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_places_show', methods: ['GET'])]
    public function show(EventsPlaces $eventsPlace): Response
    {
        return $this->render('events_places/show.html.twig', [
            'events_place' => $eventsPlace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_events_places_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventsPlaces $eventsPlace, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsPlacesType::class, $eventsPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_places_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_places/edit.html.twig', [
            'events_place' => $eventsPlace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_places_delete', methods: ['POST'])]
    public function delete(Request $request, EventsPlaces $eventsPlace, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsPlace->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventsPlace);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_events_places_index', [], Response::HTTP_SEE_OTHER);
    }
}
