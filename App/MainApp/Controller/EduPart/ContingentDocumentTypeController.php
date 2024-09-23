<?php

namespace App\MainApp\Controller\EduPart;

use App\Controller\App\EduPart\IsGranted;
use App\MainApp\Entity\ContingentDocumentType;
use App\MainApp\Form\ContingentDocumentTypeType;
use App\MainApp\Repository\ContingentDocumentTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/contingent/document/type')]
#[IsGranted("ROLE_USER")]
class ContingentDocumentTypeController extends AbstractController
{
    #[Route('/', name: 'app_contingent_document_type_index', methods: ['GET'])]
    public function index(ContingentDocumentTypeRepository $contingentDocumentTypeRepository): Response
    {
        return $this->render('contingent_document_type/index.html.twig', [
            'contingent_document_types' => $contingentDocumentTypeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contingent_document_type_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ContingentDocumentTypeRepository $contingentDocumentTypeRepository): Response
    {
        $contingentDocumentType = new ContingentDocumentType();
        $form = $this->createForm(ContingentDocumentTypeType::class, $contingentDocumentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contingentDocumentTypeRepository->save($contingentDocumentType, true);

            return $this->redirectToRoute('app_contingent_document_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contingent_document_type/new.html.twig', [
            'contingent_document_type' => $contingentDocumentType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contingent_document_type_show', methods: ['GET'])]
    public function show(ContingentDocumentType $contingentDocumentType): Response
    {
        return $this->render('contingent_document_type/show.html.twig', [
            'contingent_document_type' => $contingentDocumentType,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contingent_document_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ContingentDocumentType $contingentDocumentType, ContingentDocumentTypeRepository $contingentDocumentTypeRepository): Response
    {
        $form = $this->createForm(ContingentDocumentTypeType::class, $contingentDocumentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contingentDocumentTypeRepository->save($contingentDocumentType, true);

            return $this->redirectToRoute('app_contingent_document_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contingent_document_type/edit.html.twig', [
            'contingent_document_type' => $contingentDocumentType,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contingent_document_type_delete', methods: ['POST'])]
    public function delete(Request $request, ContingentDocumentType $contingentDocumentType, ContingentDocumentTypeRepository $contingentDocumentTypeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$contingentDocumentType->getId(), $request->request->get('_token'))) {
            $contingentDocumentTypeRepository->remove($contingentDocumentType, true);
        }

        return $this->redirectToRoute('app_contingent_document_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
