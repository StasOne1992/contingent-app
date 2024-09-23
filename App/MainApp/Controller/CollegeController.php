<?php

namespace App\MainApp\Controller;

use App\Controller\App\IsGranted;
use App\MainApp\Entity\College;
use App\MainApp\Form\CollegeType;
use App\MainApp\Repository\CollegeRepository;
use App\mod_mosregvis\Repository\modMosregVisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/college')]
#[IsGranted("ROLE_USER")]
class CollegeController extends AbstractController
{

    #[Route('/', name: 'app_college_index', methods: ['GET'])]
    public function index(CollegeRepository $collegeRepository, modmosregvisRepository $modmosregvisRepository): Response
    {
        return $this->render('college/index.html.twig', [
            'colleges' => $collegeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_college_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CollegeRepository $collegeRepository): Response
    {
        $college = new College();
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collegeRepository->save($college, true);

            return $this->redirectToRoute('app_college_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('college/new.html.twig', [
            'college' => $college,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_college_show', methods: ['GET'])]
    public function show(College $college): Response
    {
        dd($college->getActiveAdmission());
        dd($college->getModMosregVIS());
        return $this->render('college/show.html.twig', [
            'college' => $college,

        ]);
    }

    #[Route('/{id}/edit', name: 'app_college_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, College $college, CollegeRepository $collegeRepository): Response
    {
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collegeRepository->save($college, true);

            return $this->redirectToRoute('app_college_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('college/edit.html.twig', [
            'college' => $college,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_college_delete', methods: ['POST'])]
    public function delete(Request $request, College $college, CollegeRepository $collegeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$college->getId(), $request->request->get('_token'))) {
            $collegeRepository->remove($college, true);
        }

        return $this->redirectToRoute('app_college_index', [], Response::HTTP_SEE_OTHER);
    }
}
