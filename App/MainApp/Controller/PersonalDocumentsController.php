<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\PersonalDocuments;
use App\MainApp\Form\PersonalDocumentsType;
use App\MainApp\Repository\PersonalDocumentsRepository;
use App\MainApp\Repository\StudentRepository;
use App\Controller\App\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/documents/personal')]
#[IsGranted("ROLE_USER")]
class PersonalDocumentsController extends AbstractController
{
    #[Route('/', name: 'app_personal_documents_index', methods: ['GET'])]
    public function index(PersonalDocumentsRepository $personalDocumentsRepository): Response
    {
        return $this->render('personal_documents/index.html.twig', [
            'personal_documents' => $personalDocumentsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_personal_documents_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PersonalDocumentsRepository $personalDocumentsRepository,StudentRepository $studentRepository): Response
    {
        $personalDocument = new PersonalDocuments();
        $quer=$request->query->all();
        if (isset($quer['studentid'])) {
            $studentid = $quer['studentid'];
            $student=$personalDocument->getStudentById($studentid,$studentRepository);
            $personalDocument->setStudent($student);
            $personalDocument->disableuserselect=true;
        }
        else
        {
            $personalDocument->disableuserselect=false;
        }
        $form = $this->createForm(PersonalDocumentsType::class, $personalDocument);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalDocumentsRepository->save($personalDocument, true);

            return $this->redirectToRoute('app_personal_documents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('personal_documents/new.html.twig', [
            'personal_document' => $personalDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personal_documents_show', methods: ['GET'])]
    public function show(PersonalDocuments $personalDocument): Response
    {
        return $this->render('personal_documents/show.html.twig', [
            'personal_document' => $personalDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_personal_documents_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PersonalDocuments $personalDocument, PersonalDocumentsRepository $personalDocumentsRepository): Response
    {
        $personalDocument->disableuserselect=true;
        $form = $this->createForm(PersonalDocumentsType::class, $personalDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personalDocumentsRepository->save($personalDocument, true);

            return $this->redirectToRoute('app_personal_documents_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('personal_documents/edit.html.twig', [
            'personal_document' => $personalDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_personal_documents_delete', methods: ['POST'])]
    public function delete(Request $request, PersonalDocuments $personalDocument, PersonalDocumentsRepository $personalDocumentsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personalDocument->getId(), $request->request->get('_token'))) {
            $personalDocumentsRepository->remove($personalDocument, true);
        }

        return $this->redirectToRoute('app_personal_documents_index', [], Response::HTTP_SEE_OTHER);
    }

}
