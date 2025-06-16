<?php

namespace App\mod_mosregvis\Controller;

use App\mod_mosregvis\Entity\ModMosregVis_College;
use App\mod_mosregvis\Entity\ModMosregVis_Configuration;
use App\mod_mosregvis\Entity\mosregApiConnection;
use App\mod_mosregvis\Repository\modMosregVis_CollegeRepository;
use App\mod_mosregvis\Service\ModMosregApiConnectionInterfaceService;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/mod_mosregvis/api')]
class ApiController extends AbstractController
{
    private $config;

    public function __construct(private readonly RequestStack $requestStack)
    {
        $baseUrl = '/mod_mosregvis/api/';
        $this->config['url']['login'] = $baseUrl . 'auth';
        $this->config['url']['checkAuthenticated'] = $baseUrl . 'checkAuthenticated';
        $this->config['url']['initFromApi'] = $baseUrl . 'init_from_api';
        $this->config['url']['getOrgInfo'] = $baseUrl . 'get_org_info';
        return new Response(json_encode($this->config), Response::HTTP_OK);
    }

    #[Route('/getConfiguration', methods: ['GET'])]
    public function getConfiguration(): Response
    {
        return new Response(json_encode($this->config), Response::HTTP_OK);
    }

    #[Route('/auth', name: 'mod_mosregvis_api_auth', methods: ['GET', 'POST'])]
    public function apiAuth(Request $request, HttpClientInterface $httpClient, SerializerInterface $serializer): Response
    {
        $auth = json_decode($request->getContent());
        $apiConnection = new mosregApiConnection();
        $apiConnection->setUsername($auth->username);
        $apiConnection->setPassword($auth->password);
        $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection);
        $apiConnectionService->auth();
        $jsonContent = $serializer->serialize($apiConnection, 'json');
        return new Response(json_encode($jsonContent), Response::HTTP_OK);
    }

    #[Route('/init_from_api', name: 'mod_mosregvis_get_init_from_api', methods: ['GET'])]
    public function mod_mosregvis_get_init_from_api(Request $request, HttpClientInterface $httpClient, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $headers = $request->headers->all();
        $apiConnection = new mosregApiConnection($headers['x-token']['0']);
        $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection, $httpClient);
        $init_data = $apiConnectionService->init_from_api();
        dump($init_data);
        return new Response($init_data->getContent(), $init_data->getStatusCode());
    }

    #[Route('/checkAuthenticated', name: 'mod_mosregvis_api_checkAuthenticated', methods: ['GET', 'POST'])]
    public function mod_mosregvis_api_checkAuthenticated(Request $request, HttpClientInterface $httpClient, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $headers = $request->headers->all();
        $apiConnection = new mosregApiConnection($headers['x-token']['0']);
        $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection, $httpClient);
        $init_data = $apiConnectionService->init_from_api();
        return new Response($init_data->getContent(), $init_data->getStatusCode());
    }

    #[Route('/get_org_info', name: 'mod_mosregvis_get_org_info_from_api', methods: ['GET'])]
    public function mod_mosregvis_get_org_info_from_api(Request $request, HttpClientInterface $httpClient, EntityManagerInterface $entityManager, SerializerInterface $serializer, modMosregVis_CollegeRepository $mosregVISCollegeRepository): Response
    {
        $headers = $request->headers->all();
        $apiConnection = new mosregApiConnection($headers['x-token']['0']);
        $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection, $httpClient);
        $org_id = $headers['x-org-id']['0'];
        $init_data = $apiConnectionService->getOrgInfo($org_id);
        $org = (array)json_decode($init_data->getContent(), true);
        $org['guid'] = $org['id'];
        unset($org['id']);
        $org['isExist'] = false;
        if (count($current_id = $mosregVISCollegeRepository->findBy(['guid' => $org['guid']])) > 0) {
            $org['isExist'] = true;
            $org['existId'] = $current_id['0']->getId();
        }
        return new Response(json_encode($org), $init_data->getStatusCode());
    }

    #[Route('/getSpoPetitions', 'mod_mosregvis_api_get_spo_petitions', methods: ['GET'])]
    public function getSpoPetitions(Request $request, EntityManagerInterface $entityManager): Response
    {
        try {
            $apiConnection = $this->getApiConnection($request);
            if ($apiConnection == null) {
                throw new \Exception("Ошибка получения данных для авторизации в API. Выполните повторный вход в профиль АИС");
            }
            $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection);
            $init_data = $apiConnectionService->getSpoPetitionsList($entityManager);
            return new Response($init_data->getContent(), $init_data->getStatusCode());
        } catch (\Exception $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }
        return new Response("Данные не получены", Response::HTTP_NO_CONTENT);

    }

    #[Route('/getSpoPetition/{id}', 'mod_mosregvis_api_get_spo_petition', methods: ['GET'])]
    public function getSpoPetition($id, Request $request, HttpClientInterface $httpClient): Response
    {

        $apiConnectionService = new ModMosregApiConnectionInterfaceService($this->getApiConnection($request));
        return $apiConnectionService->getSpoPetition($id);
    }

    private function getApiConnection(Request $request): mosregApiConnection|null
    {
        /***
         * @var ModMosregVis_Configuration $vis_configuration
         */
        $httpClient = HttpClient::create();
        $session = $request->getSession();
        $token = $request->getSession()->get('mosreg_vis_token');
        $vis_configuration = $session->get('mosreg_vis_configuration');
        if ($token !== null || $vis_configuration !== null) {
            $apiConnection = new mosregApiConnection();
            if ($token != null) {
                $apiConnection->setToken($token);
            }
            if ($vis_configuration !== null) {
                $apiConnection->setUsername($vis_configuration->getUsername());
                $apiConnection->setPassword($vis_configuration->getPassword());
                $college = $vis_configuration->getMosregVISCollege()->getCollege();
                $admissions = $college->getAdmissions()->getValues();
                foreach ($admissions as $admission) {
                    dump($admission);
                }
                dd($college, $college->getStudentGroups()->getValues(), $admissions);
                $apiConnection->setCollegeId($vis_configuration->getOrgId());
            }
            $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection);

            if ($apiConnectionService->check_api_auth()->getStatusCode() == 401) {
                $apiConnectionService->auth();
                $session->set('mosreg_vis_token', $apiConnection->getToken());
            }
            return $apiConnection;
        }
        return null;
    }
}