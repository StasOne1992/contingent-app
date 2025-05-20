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
    public function updateReference(Request $request, modMosregVis_ConfigurationRepository $modMosregVisRepository,
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
        $mosreg_vis_token = "Token ekQ4M25odkdmb0NESitIVzVIV2E3c3R2ajg4OUlPVUFtY1kweFVNQlpMRmljQko0c0o4VjJCL2pJUCtUSFp6Mk4weldzek1DRVZIZk1qUmQ3ZlhIMmc9PQ";

        $mosreg_vis_token = $mosreg_vis_college = $mosreg_vis_configuration = null;
        if ($mosreg_vis_token == null && $mosreg_vis_college == null && $mosreg_vis_configuration == null) {
            throw  new Exception('Данные для авторизации в ВИС отсутствуют');
        }

        $mosregApiConnection->setToken($mosreg_vis_token);
        $mosregApiConnection->setUsername($mosreg_vis_configuration->getUsername());
        $mosregApiConnection->setPassword($mosreg_vis_configuration->getPassword());

        $mosregApiConnection->setPassword(null);


        dump($mosregApiConnection);
        dd();
        if (count($mod_mosreg_vis = $college->getMosregVISCollege()->getModMosregVIS()) <= 0) {
            return new Response('Не задан колледж', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $mod_mosreg_vis = $mod_mosreg_vis->get(0);


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