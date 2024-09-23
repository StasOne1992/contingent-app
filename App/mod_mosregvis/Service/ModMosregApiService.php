<?php

namespace App\mod_mosregvis\Service;

use App\MainApp\Repository\CollegeRepository;
use App\mod_mosregvis\Entity\ModMosregVis;
use App\mod_mosregvis\Entity\mosregApiConnection;
use App\mod_mosregvis\Entity\MosregVISCollege;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ModMosregApiService
{
    private string $ApiUrl = "http://prof.mo.mosreg.ru/api";
    private string $ApiAvailableUrl = "http://prof.mo.mosreg.ru";
    private array $ApiHeaders = ['Accept: */*', 'Content-Type: application/json', 'Cookie: Cookie_1=value'];
    private ?string $Token;
    private HttpClientInterface $client;
    protected RequestStack $requestStack;
    protected MosregVISCollege $college;
    protected string $username = '';
    protected string $password = '';
    private CollegeRepository $collegeRepository;


    /**
     * @throws Exception
     */
    public function __construct(RequestStack $requestStack, HttpClientInterface $client, CollegeRepository $collegeRepository)
    {
        $this->collegeRepository = $collegeRepository;
        $this->requestStack = $requestStack;
        $this->client = $client;
        $this->college = $this->collegeRepository->find($this->requestStack->getSession()->get('college')->getId());
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    private function isApiAvailable(): bool
    {
        try {
            $response = $this->client->request('GET', $this->ApiAvailableUrl);
            if (200 == $response->getStatusCode()) {
                {
                    return true;
                }
            }
        } catch (TransportExceptionInterface $e) {
            throw new Exception(sprintf("Ошибка. API недоступно. Код ошибки:%s", $response->getStatusCode()));
        }
        return false;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     */
    private function getAuthToken($username,$password): ?string
    {
        if ($this->isApiAvailable()) {
            $response = $this->client->request('POST', $this->ApiUrl . '/login',
                [
                    'headers' => ['Accept: */*', 'Content-Type: application/json', 'Cookie: Cookie_1=value'],
                    'body' => json_encode(
                        [
                            'username' => $username,
                            'password' => $password
                        ],
                        JSON_THROW_ON_ERROR)
                ]);
        }
        if ($response->getStatusCode() != 200) {
            throw new Exception(sprintf("Ошибка получения токена авторизации к API. Код ошибки:%s", $response->getStatusCode()));
        }
        $this->Token = json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)['token'];
        return $this->Token;
    }

    private function getAuthStatus(mosregApiConnection $connection)
    {
        if ($this->isApiAvailable()) {
            $response = $this->client->request('POST', $this->ApiUrl . '/check/authenticated',
                [
                    'headers' => array_merge($this->ApiHeaders, ['Authorization' => 'Token ' . $connection->getToken()])
                ]);
        }
        if ($response->getStatusCode() != 200) {
            $this->getAuthToken();
        }
    }

    /**
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws \JsonException
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     */
    private function getOrgId(): string
    {
        return '';
    }

    private function getEducationYears(): string
    {
        //http://prof.mo.mosreg.ru/api/spoEducationYear/search/byOrg?page=0&size=2000&organization=a58d08dc-8744-45f2-8f9e-b9b6015cda0e&projection=grid
        $orgID = '';
        if ($this->checkAuth($this->Token)) {
            $response = $this->client->request('POST', $this->ApiUrl . '/spoEducationYear',
                [
                    'headers' => array_merge($this->ApiHeaders, ['Authorization' => 'Token ' . $this->Token])
                ]);
        }
        if ($response->getStatusCode() != 200) {
            throw new Exception(sprintf("Ошибка получения данных организации из API. Код ошибки:%s", $response->getStatusCode()));
        }
        dd(json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR));
        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    private function checkAuth(string $token): bool
    {
        if ($this->isApiAvailable()) {
            $response = $this->client->request('GET', 'http://prof.mo.mosreg.ru/api/',
                [
                    'headers' => array_merge($this->ApiHeaders, ['Authorization' => 'Token ' . $token])
                ]);
            if ($response->getStatusCode() != 200) {
                throw new Exception(sprintf("Ошибка подключения к API. Код ошибки:%s", $response->getStatusCode()));
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * @throws Exception
     */
    private function checkModuleParams(array $params)
    {
        /***
         * @var ModMosregVis $modMosregVis
         */
        if (count($params) > 0) {
            $modMosregVis = $params[0];
            if (empty($modMosregVis->getUsername())) {
                return false;
            }
            if (empty($modMosregVis->getPassword())) {
                return false;
            }
            if (empty($modMosregVis->getOrgId())) {
                return false;
            }
        } else {
            return false;
        }
        return true;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws \JsonException
     * @throws Exception
     */
    public function ApiConnection(): mosregApiConnection
    {
        $connection = new mosregApiConnection();
        $moduleParams=$this->college->getModMosregVIS()->getValues();
        if ($this->checkModuleParams($moduleParams)) {
            $moduleParams=$moduleParams[0];
            $connection->setPassword($moduleParams->getPassword());
            $connection->setUsername($moduleParams->getUsername());
            $connection->setCollegeId($moduleParams->getOrgId());
            $connection->setApiUrl($this->ApiUrl);
            $connection->setApiAvailableUrl($this->ApiAvailableUrl);
            $connection->setApiHeaders($this->ApiHeaders);
            $connection->setToken($this->getAuthToken($moduleParams->getUsername(),$moduleParams->getPassword()));
            $countActiveAdmission = 0;
            foreach ($this->college->getAdmissions() as $admission) {
                if ($admission->isIsActive() and $countActiveAdmission <= 1) {
                    $connection->setAdmissionId($admission->getId());
                    $countActiveAdmission += 1;
                }
            }
            if ($countActiveAdmission > 1) {
                throw new Exception("Ошибка. Найдено более одной активной приемной кампании. Код ошибки:0xf001");
            } elseif ($countActiveAdmission == 0) {
                throw new Exception("Ошибка. Не найдены активные приемные кампании. Код ошибки:0xf001");
            }

        } else {
            throw new Exception("Ошибка в конфигурации модуля взаимодействия с ВИС Московской области не заполнены данные для подключения к API. Код ошибки:0xf001");
        }
        return $connection;
    }

    public function checkConnection(mosregApiConnection $connection): bool
    {
        if ($this->isApiAvailable()) {
            $response = $this->client->request('GET', 'http://prof.mo.mosreg.ru/api/',
                [
                    'headers' => array_merge($this->ApiHeaders, ['Authorization' => 'Token ' . $connection->getToken()])
                ]);
            if ($response->getStatusCode() != 200) {
                throw new Exception(sprintf("Ошибка подключения к API. Код ошибки:%s", $response->getStatusCode()));
            } else {
                return true;
            }
        }
        return false;

    }
}

