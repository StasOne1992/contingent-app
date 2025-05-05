<?php

namespace App\mod_mosregvis\Controller;

use App\mod_mosregvis\Entity\ModMosregVis_College;
use App\mod_mosregvis\Entity\mosregApiConnection;
use App\mod_mosregvis\Repository\modMosregVis_CollegeRepository;
use App\mod_mosregvis\Service\ModMosregApiConnectionInterfaceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[Route('/mod_mosregvis/api')]
class ApiController extends AbstractController
{
    private array $config;

    public function __construct()
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
        $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection, $httpClient);
        $apiConnectionService->auth();
        $jsonContent = $serializer->serialize($apiConnection, 'json');
        dump($jsonContent);
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
        $init_data = $apiConnectionService->get_org_info($org_id);
        $org = (array)json_decode($init_data->getContent(), true);
        $org['guid'] = $org['id'];
        unset($org['id']);

        $mosregCollege = $serializer->deserialize(json_encode($org), ModMosregVis_College::class, 'json');
        $org['isExist'] = false;

        if (count($mosregVISCollegeRepository->findBy(['guid' => $org['guid']])) > 0) {
            $org['isExist'] = true;
        }
        return new Response(json_encode($org), $init_data->getStatusCode());
    }

    #[Route('/getSpoPetitions', 'mod_mosregvis_api_get_spo_petitions', methods: ['GET'])]
    public function getSpoPetitions(Request $request, HttpClientInterface $httpClient,): Response
    {
        $headers = $request->headers->all();
        //$token=$headers['x-token']['0'];
        $token = 'Token bFZZRVBjQnhxZlFUYnlwcmtSTHd0RFp5emlmcGNaVVRkbXB3ckdTRThtbmVhMnlWTEYyOFNrK3FMTTdVSldUdmNPMjVrcVgzSHFnaXFIUkRNOUgrbHc9PQ';
        $apiConnection = new mosregApiConnection($token);
        $apiConnectionService = new ModMosregApiConnectionInterfaceService($apiConnection, $httpClient);
        $init_data = $apiConnectionService->getSpoPetitionsList();
        dump(json_decode($init_data));
        //$org_id = $headers['x-org-id']['0'];
        dd();
        return new Response(' ', Response::HTTP_NO_CONTENT);
    }

    #[Route('/getSpoPetition/{id}', 'mod_mosregvis_api_get_spo_petition', methods: ['GET'])]
    public function getSpoPetition(Request $request, HttpClientInterface $httpClient,): Response
    {

        return new Response(' ', Response::HTTP_NO_CONTENT);
    }
}