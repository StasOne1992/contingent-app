<?php

namespace App\MainApp\Controller\Admission\Reports;

use App\MainApp\Entity\AbiturientPetition;
use App\MainApp\Entity\AbiturientPetitionStatus;
use App\MainApp\Entity\Admission;
use App\MainApp\Repository\AbiturientPetitionRepository;
use App\MainApp\Repository\AbiturientPetitionStatusRepository;
use App\MainApp\Repository\RegionsRepository;
use App\MainApp\Service\TypicalDocuments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/reports')]
#[IsGranted("ROLE_USER")]
class AdmissionReports extends AbstractController
{
    private AbiturientPetitionRepository $abiturientPetitionRepository;
    private AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository;
    private TypicalDocuments $typicalDocuments;
    private RegionsRepository $regionsRepository;

    public function __construct(
        AbiturientPetitionRepository       $abiturientPetitionRepository,
        AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository,
        TypicalDocuments                   $typicalDocuments,
        RegionsRepository                  $regionsRepository,
    )
    {
        $this->typicalDocuments = $typicalDocuments;
        $this->abiturientPetitionStatusRepository = $abiturientPetitionStatusRepository;
        $this->abiturientPetitionRepository = $abiturientPetitionRepository;
        $this->regionsRepository = $regionsRepository;
    }

    #[Route('/{id}/summary')]
    #[IsGranted("ROLE_USER")]
    public function SummaryMetricReport(Admission $admission): ?array
    {
        $petitionList = $admission->getAbiturientPetitions();
        $currentAdmission = $admission;
        $report = array();
        foreach ($this->abiturientPetitionStatusRepository->findAll() as $item) {
            /***
             * @var AbiturientPetitionStatus $item
             */
            $abiturientPetitionStatus[$item->getName()] = $item;
        }

        $report['Count']['Title'] = 'Всего заявлений';
        $report['Count']['Icon'] = 'fa-solid fa-id-card';
        $report['Count']['Color'] = 'text-success';
        $report['Count']['Value'] = count($petitionList);
        $report['Accepted']['Title'] = 'Принято к рассмотрению';
        $report['Accepted']['Icon'] = 'fa-solid fa-badge-check';
        $report['Accepted']['Color'] = 'text-success';
        $report['Accepted']['Value'] = count(value: $currentAdmission->getAbiturientPetitions()->filter(function (AbiturientPetition $abiturientPetition) {
            return $abiturientPetition->getStatus()->getName() == 'ACCEPTED';
        }));
        $report['Rejected']['Title'] = 'Отозвано';
        $report['Rejected']['Icon'] = 'fa-solid fa-shredder';
        $report['Rejected']['Color'] = 'text-warning';
        $report['Rejected']['Value'] = count(value: $currentAdmission->getAbiturientPetitions()->filter(function (AbiturientPetition $abiturientPetition) {
            return $abiturientPetition->getStatus()->getName() == 'REJECTED';;
        }));
        $report['Registred']['Title'] = 'Зарегистрировано';
        $report['Registred']['Icon'] = ' fa-solid fa-inbox-in';
        $report['Registred']['Color'] = 'text-danger';
        $report['Registred']['Value'] = count(value: $currentAdmission->getAbiturientPetitions()->filter(function (AbiturientPetition $abiturientPetition) {
            return $abiturientPetition->getStatus()->getName() == 'REGISTRED';
        }));
        $report['Origins']['Title'] = 'Оригиналов';
        $report['Origins']['Icon'] = 'fa-solid fa-memo-circle-check';
        $report['Origins']['Color'] = 'text-success';
        //$report['Origins']['Value'] = count($this->abiturientPetitionRepository->findBy(['admission' => $currentAdmission, 'documentObtained' => true]));
        $report['Origins']['Value'] = count(value: $currentAdmission->getAbiturientPetitions()->filter(function (AbiturientPetition $abiturientPetition) {
            return $abiturientPetition->isDocumentObtained() == true;
        }));
        $report['CanLoad']['Title'] = ' для загрузки';
        $report['CanLoad']['Icon'] = 'fa-solid fa-cloud-arrow-down';
        $report['CanLoad']['Color'] = 'text-success';
        $report['CanLoad']['Value'] = 0;//count($this->petitionLoadService->getNewPetitionList());
        $report['Unique']['Title'] = 'Абитуриентов всего';
        $report['Unique']['Icon'] = 'fa-solid fa-people';
        $report['Unique']['Color'] = 'text-success';
        $report['Unique']['Value'] = $this->abiturientPetitionRepository->getUniquePetitionCount($currentAdmission->getId());
        $report['NotReg']['Title'] = 'Не присвоен номер';
        $report['NotReg']['Icon'] = 'fa-solid fa-list-ol';
        $report['NotReg']['Color'] = 'text-danger';
        $report['NotReg']['Value'] = count(value: $currentAdmission->getAbiturientPetitions()->filter(function (AbiturientPetition $abiturientPetition) {
            return $abiturientPetition->getLocalNumber() == null;
        }));
        $this->ToLoad = $report['CanLoad']['Value'];
        return $report;
    }

    public function RegionReport(Admission $admission): ?array
    {
        $report = array();
        foreach ($this->abiturientPetitionRepository->getRegionAcceptedPetitionCount($admission->getId()) as $region) {
            $report[$region['code']]['Count'] = $region['count'];
            $report[$region['code']]['Title'] = $region['title'];
        }
        return $report;
    }

    #[Route('/{id}/faculty')]
    #[IsGranted("ROLE_USER")]
    public static function FacultyReport(Admission $admission): ?array
    {

        $report = array();
        dd($admission);
        return $report;
    }

}