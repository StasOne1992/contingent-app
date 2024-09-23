<?php

namespace App\MainApp\Service\Admission;

use App\MainApp\Repository\AbiturientPetitionRepository;
use App\MainApp\Repository\AbiturientPetitionStatusRepository;
use App\MainApp\Repository\AdmissionRepository;
use App\MainApp\Repository\AdmissionStatusRepository;
use App\MainApp\Repository\FacultyRepository;
use App\Service\Admission\Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PetitionToSiteService
{
    public function __construct(
        private HttpClientInterface                $client,
        private AbiturientPetitionRepository       $abiturientPetitionRepository,
        private AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository,
        private FacultyRepository                  $facultyRepository,
        private AdmissionRepository                $admissionRepository,
        private AdmissionStatusRepository          $admissionStatusRepository,

    )
    {
        $this->currentAdmission = $this->admissionRepository->findOneBy(['status' => $this->admissionStatusRepository->findOneBy(['Name' => 'RUNNING'])]);
        $this->currentAdmissionPlan = $this->currentAdmission->getAdmissionPlans();
        $this->facultyRepository->findAll();
        $this->currentAdmission->getAbiturientPetitions();

        $this->statusREGISTRED = $this->abiturientPetitionStatusRepository->findOneBy(['name' => 'REGISTERED']);
        $this->statusREJECTED = $this->abiturientPetitionStatusRepository->findOneBy(['name' => 'REJECTED']);
        $this->statusACCEPTED = $this->abiturientPetitionStatusRepository->findOneBy(['name' => 'ACCEPTED']);
        $this->statusCHECK = $this->abiturientPetitionStatusRepository->findOneBy(['name' => 'CHECK']);
        $this->statusRECOMMENDED = $this->abiturientPetitionStatusRepository->findOneBy(['name' => 'RECOMMENDED']);
        $this->statusDOCUMENTS_OBTAINED = $this->abiturientPetitionStatusRepository->findOneBy(['name' => 'DOCUMENTS_OBTAINED']);
        $this->statusINDUCTED = $this->abiturientPetitionStatusRepository->findOneBy(['name' => 'INDUCTED']);
        $this->petitionList = $this->abiturientPetitionRepository->findBy(['admission' => $this->currentAdmission, 'status' => $this->statusACCEPTED]);
        $JsonPetitionList = array();
        foreach ($this->petitionList as $petition) {
            $currentElement['id'] = $petition->getId();
            if ($currentElement['spec'] = $petition->getFaculty()->getEducationForm()->getName() == 'PART_TIME') {
                $currentElement['spec'] = $petition->getFaculty()->getSpecialization()->getCode() . 'oz';
            } else {
                $currentElement['spec'] = $petition->getFaculty()->getSpecialization()->getCode();
            }
            $currentElement['fio'] = $petition->getLastName() . ' ' . $petition->getFirstName() . ' ' . $petition->getMiddleName();
            $currentElement['date'] = $petition->getCreatedTs()->format('Y-m-d H:i:s');
            $currentElement['numbervis'] = $petition->getNumber();
            $currentElement['ball'] = $petition->getEducationDocumentGPA();
            if ($petition->getPotok()!==null) {
                $currentElement['potok'] = $petition->getPotok();
            } else {
                $currentElement['potok'] = 100;
            }
            $currentElement['origin'] = ' ';
            if ($petition->isDocumentObtained()) {
                $currentElement['origin'] = 'Сдан';
            }
            $currentElement['dogovor'] = ' ';
            $currentElement['status'] = '1';
            $JsonPetitionList[] = $currentElement;

        }
        $this->Body = json_encode($JsonPetitionList, JSON_UNESCAPED_UNICODE);


    }

    public function loadPetitionToSite()
    {
        $this->loadToDB();
        return 0;
    }

    private function loadToDB(): void
    {
        $response = $this->client->request('POST', 'https://api.vatholm.ru/site/petitionsupload.php', [
            'body' => $this->Body,
            'headers' => [
                'authtoken' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJPbmxpbmUgSldUIEJ1aWxkZXIiLCJpYXQiOjE2ODkyMzAzNTksImV4cCI6MTcyMDc2NjM1OSwiYXVkIjoid3d3LmV4YW1wbGUuY29tIiwic3ViIjoianJvY2tldEBleGFtcGxlLmNvbSIsIkdpdmVuTmFtZSI6IkpvaG5ueSIsIlN1cm5hbWUiOiJSb2NrZXQiLCJFbWFpbCI6Impyb2NrZXRAZXhhbXBsZS5jb20iLCJSb2xlIjpbIk1hbmFnZXIiLCJQcm9qZWN0IEFkbWluaXN0cmF0b3IiXX0.mPpziu1-a5lAhmoof0sQ38mSkZLojqagkALBd_jJzO8',
            ]]);
        $statusCode = $response->getStatusCode();

        if ($statusCode !== 200) {
            throw new Exception('Ошибка отправки запроса. Код ошибки:  ' . $response->getStatusCode() . ' ' . $response->getContent());
        }

    }


}

