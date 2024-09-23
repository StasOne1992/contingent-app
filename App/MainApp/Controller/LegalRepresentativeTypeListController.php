<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\LegalRepresentativeTypeList;
use App\MainApp\Form\LegalRepresentativeTypeListType;
use App\MainApp\Repository\LegalRepresentativeTypeListRepository;
use App\Controller\App\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/leg_repres_types')]
#[IsGranted("ROLE_USER")]
class LegalRepresentativeTypeListController extends AbstractController
{
    #[Route('/', name: 'app_legal_representative_type_list_index', methods: ['GET'])]
    public function index(LegalRepresentativeTypeListRepository $legalRepresentativeTypeListRepository): Response
    {
        return $this->render('legal_representative_type_list/index.html.twig', [
            'legal_representative_type_lists' => $legalRepresentativeTypeListRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_legal_representative_type_list_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LegalRepresentativeTypeListRepository $legalRepresentativeTypeListRepository): Response
    {
        $legalRepresentativeTypeList = new LegalRepresentativeTypeList();
        $form = $this->createForm(LegalRepresentativeTypeListType::class, $legalRepresentativeTypeList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $legalRepresentativeTypeListRepository->save($legalRepresentativeTypeList, true);

            return $this->redirectToRoute('app_legal_representative_type_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legal_representative_type_list/new.html.twig', [
            'legal_representative_type_list' => $legalRepresentativeTypeList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legal_representative_type_list_show', methods: ['GET'])]
    public function show(LegalRepresentativeTypeList $legalRepresentativeTypeList): Response
    {
        return $this->render('legal_representative_type_list/show.html.twig', [
            'legal_representative_type_list' => $legalRepresentativeTypeList,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_legal_representative_type_list_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LegalRepresentativeTypeList $legalRepresentativeTypeList, LegalRepresentativeTypeListRepository $legalRepresentativeTypeListRepository): Response
    {
        $form = $this->createForm(LegalRepresentativeTypeListType::class, $legalRepresentativeTypeList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $legalRepresentativeTypeListRepository->save($legalRepresentativeTypeList, true);

            return $this->redirectToRoute('app_legal_representative_type_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('legal_representative_type_list/edit.html.twig', [
            'legal_representative_type_list' => $legalRepresentativeTypeList,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_legal_representative_type_list_delete', methods: ['POST'])]
    public function delete(Request $request, LegalRepresentativeTypeList $legalRepresentativeTypeList, LegalRepresentativeTypeListRepository $legalRepresentativeTypeListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$legalRepresentativeTypeList->getId(), $request->request->get('_token'))) {
            $legalRepresentativeTypeListRepository->remove($legalRepresentativeTypeList, true);
        }

        return $this->redirectToRoute('app_legal_representative_type_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
