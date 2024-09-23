<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\EventsResult;
use App\MainApp\Form\EventsResultType;
use App\MainApp\Repository\EventsResultRepository;
use App\MainApp\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/events/result')]
class EventsResultController extends AbstractController
{
    #[Route('/index', name: 'app_events_result_index', methods: ['GET'])]
    public function index(EventsResultRepository $eventsResultRepository): Response
    {
        return $this->render('events_result/index.html.twig', [
            'events_results' => $eventsResultRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_events_result_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, StudentRepository $studentRepository): Response
    {
        $eventsResult = new EventsResult();
        $eventsResult->lockStudent = false;
        if ($request->get('student_id') && !is_null($request->get('student_id')) && !$this->isGranted('ROLE_ROOT')) {
            $eventsResult->setStudent($studentRepository->find($request->get('student_id')));
            $eventsResult->lockStudent = true;
        } elseif ($request->get('student_id') && !is_null($request->get('student_id'))) {
            $eventsResult->setStudent($studentRepository->find($request->get('student_id')));
            $eventsResult->lockStudent = false;
        } else {
            $eventsResult->lockStudent = false;
        }

        $form = $this->createForm(EventsResultType::class, $eventsResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($eventsResult);
            $entityManager->flush();

            return $this->redirectToRoute('app_events_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_result/new.html.twig', [
            'events_result' => $eventsResult,
            'form' => $form,

        ]);
    }

    #[Route('/{id}/show', name: 'app_events_result_show', methods: ['GET'])]
    public function show(EventsResult $eventsResult): Response
    {
        return $this->render('events_result/show.html.twig', [
            'events_result' => $eventsResult,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_events_result_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EventsResult $eventsResult, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EventsResultType::class, $eventsResult);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_events_result_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('events_result/edit.html.twig', [
            'events_result' => $eventsResult,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/delete', name: 'app_events_result_delete', methods: ['POST'])]
    public function delete(Request $request, EventsResult $eventsResult, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $eventsResult->getId(), $request->request->get('_token'))) {
            $entityManager->remove($eventsResult);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_events_result_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/setStudent', name: 'app_events_result_set_student', methods: ['POST'])]
    public function setStudent(Request $request, EntityManagerInterface $entityManager, EventsResultRepository $eventsResultRepository): Response
    {
        dd($request->request->all());

    }


}
