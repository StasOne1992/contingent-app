<?php

namespace App\mod_mosregvis\Service;

use App\mod_mosregvis\Entity\ModMosregVis_College;
use App\mod_mosregvis\Entity\mosregApiConnection;
use App\mod_mosregvis\Entity\reference_eduYearStatus;
use App\mod_mosregvis\Entity\reference_SpoEducationYear;
use App\mod_mosregvis\Entity\reference_spoSpecialityDictionary;
use App\mod_mosregvis\Entity\reference_studyDiscipline;
use App\mod_mosregvis\Entity\reference_trainingProgramGradation;
use App\mod_mosregvis\Entity\reference_ufttDocumentType;
use App\mod_mosregvis\Repository\modMosregVis_CollegeRepository;
use App\mod_mosregvis\Repository\reference_SpoEducationYearRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\NotSupported;
use Exception;
use JsonException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ModMosregReferenceService
{
    private EntityManagerInterface $entityManager;
    private mosregApiConnection $apiConnection;
    private HttpClientInterface $client;

    /**
     * @param mosregApiConnection $apiConnection
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        mosregApiConnection    $apiConnection,
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
        $this->apiConnection = $apiConnection;
        $this->client = HttpClient::create();
        dd($apiConnection);
    }

    public function updateReference(string $name = ''): void
    {
        if (($name != '') && ($name != 'full')) {


        } elseif ($name == '' or $name == 'full') {
            foreach ($this->getReference("full") as $key => $value) {
                $func = 'update' . $key;
                $this->$func($value);
            }
        }
    }

    /**
     * @param string $name *Опционально. Имя сущности для обновления
     * @return ?array
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface|JsonException
     */
    public function getReference(string $name = ""): ?array
    {
        $result = array();
        switch ($name) {
            case 'ReferenceDocumentType':
                return $this->getReferenceDocumentType();
            case 'getSpoEducationYear':
                return $this->getSpoEducationYear();
            case 'eduYearStatus':
                return $this->geteduYearStatus();
            case 'getSpoSpecialityDictionary':
                return $this->getSpoSpecialityDictionary();
            case 'getStudyDiscipline':
                return $this->getStudyDiscipline();
            case 'full':
                $result['ReferenceDocumentType'] = $this->getReferenceDocumentType();
                $result['eduYearStatus'] = $this->geteduYearStatus();
                $result['SpoEducationYear'] = $this->getSpoEducationYear();
                $result['SpoSpecialityDictionary'] = $this->getSpoSpecialityDictionary();
                $result['StudyDiscipline'] = $this->getStudyDiscipline();
                break;
            default:
                break;
        }
        dump($result);
        return $result;
    }


    private function updateSpoEducationYear(array $SpoEducationYear): void
    {
        /**
         * @var reference_SpoEducationYearRepository $repository ;
         */
        $repository = $this->entityManager->getRepository(reference_SpoEducationYear::class);
        $yearStatusRepository = $this->entityManager->getRepository(reference_eduYearStatus::class);
        $collegeRepository = $this->entityManager->getRepository(ModMosregVis_College::class);
        $i = 2;
        foreach ($SpoEducationYear as $item) {
            if (count($findItem = $repository->findBy(['guid' => $item['id']])) == 0) {
                $reference = new reference_SpoEducationYear();
            } else {
                $reference = $findItem[0];
            }
            /**
             * @var reference_SpoEducationYear $reference
             */
            $reference->setOrderId($i);
            $i++;
            $reference->setGuid($item['id']);
            $reference->setName($item['educationYearDictionary']['name']);
            if ($currentYearStatus = $yearStatusRepository->findBy(['code' => $item['educationYearStatus']['code']])) {
                $reference->setYearStatus($currentYearStatus[0]);
            }
            $reference->setCollege($collegeRepository->findBy(['guid' => $this->apiConnection->getCollegeId()])[0]);

            $reference->setStartDate(date_create($item['educationYearDictionary']['startDate']));
            $reference->setEndDate(date_create($item['educationYearDictionary']['endDate']));
            $this->entityManager->persist($reference);
            $this->entityManager->flush();
        }
    }

    private function updateeduYearStatus(array $eduYearStatus): void
    {
        $repository = $this->entityManager->getRepository(reference_eduYearStatus::class);
        foreach ($eduYearStatus as $item) {
            if (count($repository->findBy(['code' => $item['code']])) == 0) {
                $reference = new reference_eduYearStatus();

            } else {
                try {
                    $reference = $repository->findBy(['code' => $item['code']])[0];
                } catch (NotSupported $e) {
                }
            }
            $reference->setName($item['name']);
            $reference->setCode($item['code']);
            $reference->setTitle($item['title']);
            $this->entityManager->persist($reference);
            $this->entityManager->flush();
        }
    }

    private function updateReferenceDocumentType(array $ReferenceDocumentType): void
    {
        $documentTypeRepository = $this->entityManager->getRepository(reference_ufttDocumentType::class);
        foreach ($ReferenceDocumentType as $item) {
            if (count($documentTypeRepository->findBy(['code' => $item['code']])) == 0) {
                $documentType = new reference_ufttDocumentType();

            } else {
                try {
                    $documentType = $documentTypeRepository->findBy(['code' => $item['code']])[0];
                } catch (NotSupported $e) {
                }
            }
            $documentType->setName($item['name']);
            $documentType->setCode($item['code']);
            $documentType->setTitle($item['title']);
            $this->entityManager->persist($documentType);
            $this->entityManager->flush();
        }
    }

    private function updateSpoSpecialityDictionary(array $spoSpecialityDictionary): void
    {
        $repository = $this->entityManager->getRepository(reference_spoSpecialityDictionary::class);
        $trainingProgramGradationRepository = $this->entityManager->getRepository(reference_trainingProgramGradation::class);

        $PPKRS = $trainingProgramGradationRepository->findBy(['name' => 'PPKRS'])[0];
        $PPSSZ = $trainingProgramGradationRepository->findBy(['name' => 'PPSSZ'])[0];
        foreach ($spoSpecialityDictionary as $item) {
            /**
             * @var reference_spoSpecialityDictionary $referense ;
             */
            $reference = new reference_spoSpecialityDictionary();
            if (!count($foundItem = $repository->findBy(['code' => $item['code']])) == 0) {
                $reference = $foundItem[0];
            }
            $reference->setidVis($item['id']);
            $reference->setName($item['name']);
            $reference->setCode($item['code']);
            $reference->setQualification($item['qualification']);
            if ($item['trainingProgramGradation']['name'] == "PPKRS") {
                $reference->setTrainingProgramGradation($PPKRS);
            } elseif ($item['trainingProgramGradation']['name'] == 'PPSSZ') {
                $reference->setTrainingProgramGradation($PPSSZ);
            } else {
                $reference->setTrainingProgramGradation(null);
            }
            $this->entityManager->persist($reference);
            $this->entityManager->flush();
        }
    }

    private function updateStudyDiscipline(array $studyDisciplines): void
    {
        $repository = $this->entityManager->getRepository(reference_studyDiscipline::class);
        foreach ($studyDisciplines as $item) {
            /**
             * @var reference_studyDiscipline $referense ;
             */
            $reference = new reference_studyDiscipline();
            if (!count($foundItem = $repository->findBy(['idVis' => $item['id']])) == 0) {
                $reference = $foundItem[0];
            }
            $reference->setIdVis($item['id']);
            $reference->setName($item['name']);
            $reference->setDisciplineGroup(is_null($item['disciplineGroup']) ? null : $item['disciplineGroup']['title']);
            $reference->setIsSpo($item['isSpo']);
            $reference->setIsOdo($item['isOdo']);
            $reference->setIsSchool($item['isSchool']);
            $this->entityManager->persist($reference);
            $this->entityManager->flush();
        }
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private
    function getReferenceDocumentType(): array
    {

        $response = $this->client->request('GET', $this->apiConnection->getApiUrl() . '/reference/ufttDocumentType',
            [
                'headers' => array_merge($this->apiConnection->getApiHeaders())
            ]);

        if ($response->getStatusCode() != 200) {
            new Exception(sprintf("Ошибка получения данных организации из API. Код ошибки:%s", $response->getStatusCode()));
        } elseif ($response->getStatusCode() == 401) {
            throw new Exception(sprintf("Ошибка авторизации API. Код ошибки: 401 Unauthorized"));
        }
        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private
    function geteduYearStatus(): array
    {

        $response = $this->client->request('GET', $this->apiConnection->getApiUrl() . '/spo/reference/eduYearStatus',
            [
                'headers' => array_merge($this->apiConnection->getApiHeaders())
            ]);

        if ($response->getStatusCode() != 200) {
            throw new Exception(sprintf("Ошибка получения данных организации из API. Код ошибки:%s", $response->getStatusCode()));
        } elseif ($response->getStatusCode() == 401) {
            throw new Exception("Ошибка авторизации API. Код ошибки: 401 Unauthorized ");
        }
        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private
    function getSpoEducationYear(): array
    {
        $response = $this->client->request('GET', $this->apiConnection->getApiUrl() . '/spoEducationYear/search/byOrg?page=0&size=5000&organization=' . $this->apiConnection->getCollegeId() . '&projection=grid',
            [
                'headers' => array_merge($this->apiConnection->getApiHeaders())
            ]);

        if ($response->getStatusCode() != 200) {
            new Exception(sprintf("Ошибка получения данных организации из API. Код ошибки:%s", $response->getStatusCode()));
        } elseif ($response->getStatusCode() == 401) {
            new Exception(sprintf("Ошибка авторизации API. Код ошибки: 401 Unauthorized "));
        }
        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)['_embedded']['spoEducationYears'];
    }

    private
    function getSpoSpecialityDictionary(): array
    {

        $response = $this->client->request('GET', $this->apiConnection->getApiUrl() . '/spoSpecialityDictionary?size=5000&sort=name&order=asc',
            [
                'headers' => array_merge($this->apiConnection->getApiHeaders())
            ]);
        if ($response->getStatusCode() != 200) {
            new Exception(sprintf("Ошибка получения данных организации из API. Код ошибки:%s", $response->getStatusCode()));
        } elseif ($response->getStatusCode() == 401) {
            throw new Exception(sprintf("Ошибка авторизации API. Код ошибки: 401 Unauthorized "));
        }
        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)['_embedded']['spoSpecialityDictionaries'];
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private
    function getStudyDiscipline(): array
    {
        $response = $this->client->request('GET', $this->apiConnection->getApiUrl() . '/studyDiscipline/search/forSpo?page=0&size=5000&sort=name&order=asc',
            [
                'headers' => array_merge($this->apiConnection->getApiHeaders())
            ]);

        if ($response->getStatusCode() != 200) {
            new Exception(sprintf("Ошибка получения данных организации из API. Код ошибки:%s", $response->getStatusCode()));
        } elseif ($response->getStatusCode() == 401) {
            new Exception(sprintf("Ошибка авторизации API. Код ошибки: 401 Unauthorized "));
        }
        return json_decode($response->getContent(), true, 512, JSON_THROW_ON_ERROR)['_embedded']['studyDisciplines'];
    }
}