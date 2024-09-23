<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\Faculty;
use App\MainApp\Form\FacultyType;
use App\MainApp\Repository\FacultyRepository;
use App\Controller\App\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/faculty')]
#[IsGranted("ROLE_USER")]
class FacultyController extends AbstractController
{
    #[Route('/', name: 'app_faculty_index', methods: ['GET'])]
    public function index(FacultyRepository $facultyRepository): Response
    {
        return $this->render('faculty/index.html.twig', [
            'faculties' => $facultyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_faculty_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FacultyRepository $facultyRepository): Response
    {
        $faculty = new Faculty();
        $form = $this->createForm(FacultyType::class, $faculty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facultyRepository->save($faculty, true);

            return $this->redirectToRoute('app_faculty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('faculty/new.html.twig', [
            'faculty' => $faculty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_faculty_show', methods: ['GET'])]
    public function show(Faculty $faculty): Response
    {
        return $this->render('faculty/show.html.twig', [
            'faculty' => $faculty,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_faculty_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Faculty $faculty, FacultyRepository $facultyRepository): Response
    {
        $form = $this->createForm(FacultyType::class, $faculty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $facultyRepository->save($faculty, true);

            return $this->redirectToRoute('app_faculty_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('faculty/edit.html.twig', [
            'faculty' => $faculty,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_faculty_delete', methods: ['POST'])]
    public function delete(Request $request, Faculty $faculty, FacultyRepository $facultyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$faculty->getId(), $request->request->get('_token'))) {
            $facultyRepository->remove($faculty, true);
        }

        return $this->redirectToRoute('app_faculty_index', [], Response::HTTP_SEE_OTHER);
    }
}
