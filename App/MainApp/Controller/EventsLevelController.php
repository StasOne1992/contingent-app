<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\EventsLevel;
use App\MainApp\Form\EventsLevelType;
use App\MainApp\Repository\EventsLevelRepository;
use App\Controller\App\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/events/level')]

class EventsLevelController extends AbstractController
{
    #[Route('/', name: 'app_events_level_index', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function index(EventsLevelRepository $eventsLevelRepository): Response
    {
        return $this->render('events_level/index.html.twig', [
            'events_levels' => $eventsLevelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_events_level_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventsLevel = new EventsLevel();
        $form = $this->createForm(EventsLevelType::class, $eventsLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventsLevel);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_level/new.html.twig', [
            'events_level' => $eventsLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_level_show', methods: ['GET'])]
    public function show(EventsLevel $eventsLevel): Response
    {
        return $this->render('events_level/show.html.twig', [
            'events_level' => $eventsLevel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_events_level_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventsLevel $eventsLevel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsLevelType::class, $eventsLevel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_level_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_level/edit.html.twig', [
            'events_level' => $eventsLevel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_level_delete', methods: ['POST'])]
    public function delete(Request $request, EventsLevel $eventsLevel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsLevel->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventsLevel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_events_level_index', [], Response::HTTP_SEE_OTHER);
    }
}
