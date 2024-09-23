<?php

namespace App\mod_mosregvis\Controller;


use App\MainApp\Repository\ModMosregVisRepository;
use App\mod_mosregvis\Service\ModMosregApiProvider;
use App\mod_mosregvis\Service\ModMosregApiService;
use App\mod_mosregvis\Service\ModMosregReferenceService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/mod_mosregvis/reference')]
#[IsGranted("ROLE_USER")]
class mod_mosregvis_referenceController extends AbstractController
{
    #[Route('/updateReference', name: 'mod_mosregvis_reference_update_reference', methods: ['POST', 'GET'])]
    public function updateReference(ModMosregVisRepository $modMosregVisRepository, HttpClientInterface $client, ModMosregApiService $mosregApiService, EntityManagerInterface $entityManager): Response
    {

        $apiConnection = $mosregApiService->ApiConnection();
        $modMosregApiProvider = new ModMosregReferenceService($apiConnection, $client, $entityManager);
        $modMosregApiProvider->updateReference("full");
        dd('');
        return $this->render('@mod_mosregvis/index.html.twig',
            [
                'modMosregVis' => array()
            ]
        );
    }
}