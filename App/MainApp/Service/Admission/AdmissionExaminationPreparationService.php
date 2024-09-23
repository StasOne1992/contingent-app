<?php

namespace App\MainApp\Service\Admission;

use App\MainApp\Entity\AbiturientPetition;
use App\MainApp\Entity\AdmissionExaminationResult;
use App\MainApp\Repository\AbiturientPetitionRepository;
use App\MainApp\Repository\AdmissionExaminationRepository;
use App\MainApp\Repository\AdmissionExaminationResultRepository;
use App\MainApp\Repository\AdmissionExaminationSubjectsRepository;
use App\MainApp\Repository\AdmissionPlanRepository;
use App\MainApp\Repository\AdmissionRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service to prepair petition to Examination
 */


class AdmissionExaminationPreparationService
{
    /***
     * @param AbiturientPetitionRepository $abiturientPetitionRepository
     * @param AdmissionExaminationResultRepository $admissionExaminationResultRepository
     * @param AdmissionExaminationRepository $admissionExaminationRepository
     * @param AdmissionRepository $admissionRepository
     * @param AdmissionExaminationSubjectsRepository $admissionExaminationSubjectsRepository
     * @param AdmissionPlanRepository $admissionPlanRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        private AbiturientPetitionRepository           $abiturientPetitionRepository,
        private AdmissionExaminationResultRepository   $admissionExaminationResultRepository,
        private AdmissionExaminationRepository         $admissionExaminationRepository,
        private AdmissionRepository                    $admissionRepository,
        private AdmissionExaminationSubjectsRepository $admissionExaminationSubjectsRepository,
        private AdmissionPlanRepository                $admissionPlanRepository,
        private EntityManagerInterface                 $entityManager,
    )
    {
        $this->admissionExaminationRepository->findAll();
        $this->admissionExaminationResultRepository->findAll();
        $this->admissionExaminationSubjectsRepository->findAll();
        $this->admissionPlanRepository->findAll();
    }

    /**
     * Публичная функция, которая выполняет получение списка заявлений,
     * выполняет подготовку к созданию ведомостей экзаменов
     * @param $PetitionList
     * @return void
     */
    public function AdmissionExaminationPreparationPrepare($PetitionList,$AdmissionExamination): void
    {
        /**
         * @var AbiturientPetition $Petition
         */
        foreach ($PetitionList as $Petition) {
            dump('START ' . $Petition->getNumber());
            dump($Petition->getAdmissionPlanPosition()->getAdmissionExaminations()->getValues());
                dump($AdmissionExamination);
                dump('START RESULT');
                if ($Petition->getResult()->count() != 0 or $Petition->getResult()->count() != null) {
                    if (!$this->admissionExaminationResultRepository->findOneBy(['AbiturientPetition' => $Petition, 'AdmissionExamination' => $AdmissionExamination])) {
                        dump('No current Admission Examination row');
                        $ExaminationResult = new AdmissionExaminationResult();
                        $ExaminationResult->setAdmissionExamination($AdmissionExamination);
                        $ExaminationResult->setAbiturientPetition($Petition);
                        $ExaminationResult->setMark(0);
                        $this->entityManager->persist($ExaminationResult);
                        $this->entityManager->flush();
                        dump('Created Examination Result Row: ' . $ExaminationResult->getId());
                    }

                } else {
                    dump('Not Result Found');
                    $ExaminationResult = new AdmissionExaminationResult();
                    $ExaminationResult->setAdmissionExamination($AdmissionExamination);
                    $ExaminationResult->setAbiturientPetition($Petition);
                    $ExaminationResult->setMark(0);
                    $this->entityManager->persist($ExaminationResult);
                    $this->entityManager->flush();
                    dump('Created Examination Result Row: ' . $ExaminationResult->getId());
                }
                dump('END RESULT');

            dump('END ' . $Petition->getNumber());
        }
    }
}