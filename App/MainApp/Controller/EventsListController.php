<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\EventsList;
use App\MainApp\Form\EventsListType;
use App\MainApp\Repository\EventsListRepository;
use App\Controller\App\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/events/list')]
#[IsGranted("ROLE_USER")]
class EventsListController extends AbstractController
{
    #[Route('/', name: 'app_events_list_index', methods: ['GET'])]
    public function index(EventsListRepository $eventsListRepository): Response
    {
        return $this->render('events_list/index.html.twig', [
            'events_lists' => $eventsListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_events_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventsList = new EventsList();
        $form = $this->createForm(EventsListType::class, $eventsList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventsList);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_list/new.html.twig', [
            'events_list' => $eventsList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_events_list_show', methods: ['GET'])]
    public function show(EventsList $eventsList): Response
    {
        return $this->render('events_list/show.html.twig', [
            'events_list' => $eventsList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_events_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventsList $eventsList, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsListType::class, $eventsList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_list/edit.html.twig', [
            'events_list' => $eventsList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_events_list_delete', methods: ['POST'])]
    public function delete(Request $request, EventsList $eventsList, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsList->getId(), $request->request->get('_token'))) {
            if ($this->isGranted('ROLE_ROOT'))
            {
            $entityManager->remove($eventsList);
            $entityManager->flush();
            }
            else {
                $eventsList->setIsArchived(true);
                $entityManager->flush();
            }
        }

        return $this->redirectToRoute('app_events_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
