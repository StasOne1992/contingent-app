<?php

namespace App\mod_mosregvis\Controller;


use App\MainApp\Entity\College;
use App\mod_mosregvis\Entity\ModMosregVis_College;
use App\mod_mosregvis\Entity\ModMosregVis_Configuration;
use App\mod_mosregvis\Entity\mosregApiConnection;
use App\mod_mosregvis\Repository\modMosregVis_ConfigurationRepository;
use App\mod_mosregvis\Service\ModMosregApiConnectionInterfaceService;
use App\mod_mosregvis\Service\ModMosregReferenceService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/mod_mosregvis/reference')]
#[IsGranted("ROLE_USER")]
class ReferenceController extends AbstractController
{
    #[Route('/index', name: 'mod_mosregvis_reference_index', methods: ['POST', 'GET'])]
    public function index(): Response
    {
        return new Response('', Response::HTTP_OK);
    }

    #[Route('/update', name: 'mod_mosregvis_reference_update_reference', methods: ['POST', 'GET'])]
    public function updateReference(Request                              $request,
                                    modMosregVis_ConfigurationRepository $modMosregVisRepository,
                                    HttpClientInterface                  $client,
                                    EntityManagerInterface               $entityManager): Response
    {
        /**
         * @var ModMosregVis_College $mosreg_vis_college
         * @var ModMosregVis_Configuration $mosreg_vis_configuration
         */
        $session = $request->getSession();
        $mosregApiConnection = new mosregApiConnection();
        $mosreg_vis_college = $session->get('mosreg_vis_college');
        $mosreg_vis_configuration = $session->get('mosreg_vis_configuration');
        $mosreg_vis_token = $session->get('mosreg_vis_token');

        if ($mosreg_vis_token == null && $mosreg_vis_college == null && $mosreg_vis_configuration = null) {
            dump($mosreg_vis_token == null, $mosreg_vis_college == null, $mosreg_vis_configuration = null);
            return new Response('Данные для авторизации в ВИС отсутствуют', status: Response::HTTP_UNAUTHORIZED);
        }
        if ($mosreg_vis_token != null) {

            $mosregApiConnection->setToken($mosreg_vis_token);
        }
        if ($mosreg_vis_college != null && $mosreg_vis_configuration != null && $mosreg_vis_token == null) {
            $mosregApiConnection->setUsername($mosreg_vis_configuration->getUsername());
            $mosregApiConnection->setPassword($mosreg_vis_configuration->getPassword());
        }
        if ($mosreg_vis_configuration->getMosregVISCollege() == null) {
            return new Response('Не задан колледж', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $apiInterface = new ModMosregApiConnectionInterfaceService($mosregApiConnection);
        if ($apiInterface->check_api_auth()->getStatusCode() != 200) {
            $apiInterface->auth();
        }

        $modMosregApiProvider = new ModMosregReferenceService($mosregApiConnection, $entityManager);
        $modMosregApiProvider->updateReference("full");
        dd('');
        return $this->render('@mod_mosregvis/index.html.twig',
            [
                'modMosregVis' => array()
            ]
        );
    }
}