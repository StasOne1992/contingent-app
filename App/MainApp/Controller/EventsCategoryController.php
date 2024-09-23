<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\EventsCategory;
use App\MainApp\Form\EventsCategoryType;
use App\MainApp\Repository\EventsCategoryRepository;
use App\Controller\App\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/events/category')]
#[IsGranted("ROLE_USER")]
class EventsCategoryController extends AbstractController
{
    #[Route('/', name: 'app_events_category_index', methods: ['GET'])]
    public function index(EventsCategoryRepository $eventsCategoryRepository): Response
    {
        return $this->render('events_category/index.html.twig', [
            'events_categories' => $eventsCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_events_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $eventsCategory = new EventsCategory();
        $form = $this->createForm(EventsCategoryType::class, $eventsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventsCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_category/new.html.twig', [
            'events_category' => $eventsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_category_show', methods: ['GET'])]
    public function show(EventsCategory $eventsCategory): Response
    {
        return $this->render('events_category/show.html.twig', [
            'events_category' => $eventsCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_events_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventsCategory $eventsCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsCategoryType::class, $eventsCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_category/edit.html.twig', [
            'events_category' => $eventsCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_events_category_delete', methods: ['POST'])]
    public function delete(Request $request, EventsCategory $eventsCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventsCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventsCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_events_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
