<?php

namespace App\mod_mosregvis\Controller;


use App\MainApp\Entity\College;
use App\mod_mosregvis\Entity\ModMosregVis_Configuration;
use App\mod_mosregvis\Entity\mosregApiConnection;
use App\mod_mosregvis\Repository\modMosregVis_ConfigurationRepository;
use App\mod_mosregvis\Service\ModMosregApiConnectionInterfaceService;
use App\mod_mosregvis\Service\ModMosregReferenceService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/mod_mosregvis/reference')]
#[IsGranted("ROLE_USER")]
class ReferenceController extends AbstractController
{
    public function __construct(private readonly Security $security)
    {
    }

    #[Route('/update', name: 'mod_mosregvis_reference_update_reference', methods: ['POST', 'GET'])]
    public function updateReference(modMosregVis_ConfigurationRepository $modMosregVisRepository,
                                    HttpClientInterface                  $client,
                                    EntityManagerInterface               $entityManager): Response
    {
        /***
         * @var College $college
         */
        $college = $this->security->getUser()->getCollege();
        if (count($mod_mosreg_vis = $college->getMosregVISCollege()->getModMosregVIS()) <= 0) {
            return new Response('Не задан колледж', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $mod_mosreg_vis = $mod_mosreg_vis->get(0);

        $mosregApiConnection = new mosregApiConnection();
        $mosregApiConnection->setCollegeId($mod_mosreg_vis->getMosregVISCollege()->getGuid());
        $mosregApiConnection->setUsername($mod_mosreg_vis->getUsername());
        $mosregApiConnection->setPassword($mod_mosreg_vis->getPassword());
        dump($mosregApiConnection);
        $apiInterface = new ModMosregApiConnectionInterfaceService(connection: $mosregApiConnection, client: $client);
        $apiInterface->auth();
        $modMosregApiProvider = new ModMosregReferenceService($mosregApiConnection, $client, $entityManager);
        $modMosregApiProvider->updateReference("full");
        dd('');
        return $this->render('@mod_mosregvis/index.html.twig',
            [
                'modMosregVis' => array()
            ]
        );
    }
}