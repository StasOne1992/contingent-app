<?php

namespace App\mod_admission\Controller;

use App\MainApp\Repository\RegionsRepository;
use App\mod_admission\Controller\Reports\AdmissionReports;
use App\mod_admission\Entity\AbiturientPetitionStatus;
use App\mod_admission\Entity\Admission;
use App\mod_admission\Repository\AbiturientPetitionRepository;
use App\mod_admission\Repository\AbiturientPetitionStatusRepository;
use App\mod_admission\Repository\AdmissionPlanRepository;
use App\mod_admission\Repository\AdmissionRepository;
use App\mod_admission\Repository\AdmissionStatusRepository;
use App\mod_education\Repository\FacultyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/admission/dashboard')]
#[IsGranted("ROLE_USER")]
class AdmissionDashboard extends AbstractController
{
    private AdmissionRepository $admissionRepository;
    private AbiturientPetitionRepository $abiturientPetitionRepository;
    private AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository;
    private AdmissionStatusRepository $admissionStatusRepository;
    private readonly AdmissionPlanRepository $admissionPlanRepository;
    private FacultyRepository $facultyRepository;
    private RegionsRepository $regionsRepository;
    /**
     * @var \App\mod_admission\Entity\AbiturientPetitionStatus
     */
    private AbiturientPetitionStatus $statusREGISTRED;
    /**
     * @var \App\mod_admission\Entity\AbiturientPetitionStatus
     */
    private AbiturientPetitionStatus $statusREJECTED;
    /**
     * @var \App\mod_admission\Entity\AbiturientPetitionStatus
     */
    private AbiturientPetitionStatus $statusACCEPTED;
    /**
     * @var \App\mod_admission\Entity\AbiturientPetitionStatus
     */
    private AbiturientPetitionStatus $statusCHECK;
    /**
     * @var \App\mod_admission\Entity\AbiturientPetitionStatus
     */
    private AbiturientPetitionStatus $statusRECOMMENDED;
    /**
     * @var \App\mod_admission\Entity\AbiturientPetitionStatus
     */
    private AbiturientPetitionStatus $statusDOCUMENTS_OBTAINED;
    /**
     * @var \App\mod_admission\Entity\AbiturientPetitionStatus
     */
    private AbiturientPetitionStatus $statusINDUCTED;
    private \Doctrine\Common\Collections\Collection $currentAdmissionPlan;
    private ?Admission $currentAdmission = null;
    private ?array $SummaryMetricReport = array();
    private ?array $byRegionsReport = array();
    private ?int $ToLoad = null;
    private bool $HaveAddmission=false;

    public function __construct(
        AdmissionRepository                $admissionRepository,
        AbiturientPetitionRepository       $abiturientPetitionRepository,
        AbiturientPetitionStatusRepository $abiturientPetitionStatusRepository,
        AdmissionStatusRepository          $admissionStatusRepository,
        AdmissionPlanRepository            $admissionPlanRepository,
        FacultyRepository                  $facultyRepository,
        RegionsRepository                  $regionsRepository,
        AdmissionReports                   $admissionReports,
    )
    {
        $this->regionsRepository = $regionsRepository;
        $this->facultyRepository = $facultyRepository;
        $this->admissionPlanRepository = $admissionPlanRepository;
        $this->admissionStatusRepository = $admissionStatusRepository;
        $this->abiturientPetitionStatusRepository = $abiturientPetitionStatusRepository;
        $this->abiturientPetitionRepository = $abiturientPetitionRepository;
        $this->admissionRepository = $admissionRepository;
        if (count($this->admissionRepository->findAll()) > 0) {
            $this->HaveAddmission=true;
            $this->currentAdmission = $this->admissionRepository->findOneBy(['status' => $this->admissionStatusRepository->findOneBy(['Name' => 'RUNNING'])]);
            $this->currentAdmissionPlan = $this->currentAdmission->getAdmissionPlans();
            $this->facultyRepository->findAll();
            $abiturientPetitionStatus = array();
            foreach ($this->abiturientPetitionStatusRepository->findAll() as $item) {
                /***
                 * @var AbiturientPetitionStatus $item
                 */
                $abiturientPetitionStatus[$item->getName()] = $item;
            }
            $this->SummaryMetricReport = $admissionReports->SummaryMetricReport($this->currentAdmission);

            $this->statusREGISTRED = $abiturientPetitionStatus['REGISTERED'];
            $this->statusREJECTED = $abiturientPetitionStatus['REJECTED'];
            $this->statusACCEPTED = $abiturientPetitionStatus['ACCEPTED'];
            $this->statusCHECK = $abiturientPetitionStatus['CHECK'];
            $this->statusRECOMMENDED = $abiturientPetitionStatus['RECOMMENDED'];
            $this->statusDOCUMENTS_OBTAINED = $abiturientPetitionStatus['DOCUMENTS_OBTAINED'];
            $this->statusINDUCTED = $abiturientPetitionStatus['INDUCTED'];
            $petitionList = $this->currentAdmission->getAbiturientPetitions();
            /*$this->SummaryMetricReport = array();
    */
            $this->ToLoad = $this->SummaryMetricReport['CanLoad']['Value'];
            $this->byRegionsReport = $admissionReports->RegionReport($this->currentAdmission);


            $counter = 0;
            foreach ($this->currentAdmissionPlan as $item) {
                $this->facultyPetitionCount[$item->getId()]['Admission'] = $this->currentAdmission;
                $this->facultyPetitionCount[$item->getId()]['Faculty'] = $item->getFaculty();
                $this->facultyPetitionCount[$item->getId()]['Rejected'] = count($this->abiturientPetitionRepository->findBy(['admission' => $this->currentAdmission, 'Faculty' => $item->getFaculty(), 'status' => $this->statusREJECTED]));
                $this->facultyPetitionCount[$item->getId()]['Registred'] = count($this->abiturientPetitionRepository->findBy(['admission' => $this->currentAdmission, 'Faculty' => $item->getFaculty(), 'status' => $this->statusREGISTRED]));
                $this->facultyPetitionCount[$item->getId()]['Origins'] = count($this->abiturientPetitionRepository->findBy(['admission' => $this->currentAdmission, 'Faculty' => $item->getFaculty(), 'documentObtained' => true]));
                $this->facultyPetitionCount[$item->getId()]['PetitionCount'] = $item->getFaculty()->getAbiturientPetitions()->count();
                $this->facultyPetitionCount[$item->getId()]['Enroll'] = count($this->abiturientPetitionRepository->findBy(['admission' => $this->currentAdmission, 'Faculty' => $item->getFaculty(), 'status' => $this->statusRECOMMENDED]));
                $this->facultyPetitionCount[$item->getId()]['Induct'] = count($this->abiturientPetitionRepository->findBy(['admission' => $this->currentAdmission, 'Faculty' => $item->getFaculty(), 'status' => $this->statusINDUCTED]));
                $this->facultyPetitionCount[$item->getId()]['FISGIA'] = count($this->abiturientPetitionRepository->findBy(['admission' => $this->currentAdmission, 'Faculty' => $item->getFaculty(), 'LoadToFISGIA' => true]));
                $counter++;
            }
        } else {
            $this->facultyPetitionCount = [];

        }
    }

    #[Route('/', name: 'app_admission_dashboard_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('@mod_admission/admission_dashboard/admission_dashboard.html.twig',
            [
                'HaveAdmission'=> $this->HaveAddmission,
                'facultyPetitionCount' => $this->facultyPetitionCount,
                'SummaryMetricReport' => $this->SummaryMetricReport,
                'ToLoad' => $this->ToLoad,
                'byRegionsReport' => $this->byRegionsReport,
            ]);
    }

    #[Route('/faculty/{admission}/{faculty}', name: 'app_admission_dashboard_faculty_petition_index', methods: ['GET'])]
    public function faculty_petition_index(Request $request, FacultyRepository $facultyRepository): Response
    {
        $admissionId = $request->get('admission');
        $faculty = $request->get('faculty');
        $petitionList = $this->abiturientPetitionRepository->findBy(['admission' => $admissionId, 'Faculty' => $faculty], ['educationDocumentGPA' => 'DESC']);
        $faculty = $facultyRepository->find($faculty);
        return $this->render('abiturient_petition/index.html.twig',
            [
                'abiturient_petitions' => $petitionList,
                'faculty' => $faculty,
                'facultyTitle' => $faculty->getName(),

            ]);
    }
}
