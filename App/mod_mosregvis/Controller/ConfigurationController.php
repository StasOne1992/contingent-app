<?php

namespace App\mod_mosregvis\Controller;

use App\mod_mosregvis\Entity\ModMosregVis_Configuration;
use App\mod_mosregvis\Form\modMosregVis_ConfigurationType;
use App\mod_mosregvis\Repository\modMosregVis_ConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mod_mosregvis/configuration')]
#[IsGranted("ROLE_USER")]
class ConfigurationController extends AbstractController
{
    #[Route('/index', name: 'mod_mosregvis_index', methods: ['GET'])]
    public function index(modMosregVis_ConfigurationRepository $ModMosregVisRepository): Response
    {
        return $this->render('@mod_mosregvis/modMosregVis_Configuration/index.html.twig',
            [
                'modMosregVis' => $ModMosregVisRepository->findAll()
            ]
        );
    }

    #[Route('/new', name: 'mod_mosregvis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $modMosregVis_Configuration = new modMosregVis_Configuration();
        $form = $this->createForm(modMosregVis_ConfigurationType::class, $modMosregVis_Configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($modMosregVis_Configuration->getPassword());
            $entityManager->persist($modMosregVis_Configuration);
            $entityManager->flush();
            return $this->redirectToRoute('mod_mosregvis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@mod_mosregvis/modMosregVis_Configuration/new.html.twig', [
            'education_plan' => $modMosregVis_Configuration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'mod_mosregvis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ModMosregVis_Configuration $modMosregVis_Configuration, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(modMosregVis_ConfigurationType::class, $modMosregVis_Configuration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($modMosregVis_Configuration->getPassword());
            $entityManager->persist($modMosregVis_Configuration);
            $entityManager->flush();

            return $this->redirectToRoute('mod_mosregvis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@mod_mosregvis/modMosregVis_Configuration/edit.html.twig', [
            'modMosregVis' => $modMosregVis_Configuration,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'mod_mosregvis_show', methods: ['GET'])]
    public function show(modMosregVis_Configuration $modMosregVis_Configuration): Response
    {
        return $this->render('@mod_mosregvis/modMosregVis_Configuration/show.html.twig', [
            'modMosregVis' => $modMosregVis_Configuration,
        ]);
    }

}