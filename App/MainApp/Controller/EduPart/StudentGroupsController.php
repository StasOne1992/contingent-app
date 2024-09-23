<?php

namespace App\MainApp\Controller\EduPart;

use App\Controller\App\EduPart\Student;
use App\MainApp\Entity\StudentGroups;
use App\MainApp\Form\StudentGroupsType;
use App\MainApp\Repository\EventsListRepository;
use App\MainApp\Repository\StudentGroupsRepository;
use App\MainApp\Repository\StudentRepository;
use App\MainApp\Repository\UserRepository;
use App\MainApp\Service\StudentGroupsService;
use App\MainApp\Service\TypicalDocuments;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/student-groups')]
#[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
class StudentGroupsController extends AbstractController
{
    public function __construct(
        private StudentGroupsService $studentGroupsService,
        public TypicalDocuments      $typicalDocuments,
    )
    {
    }

    #[Route('/', name: 'app_student_groups_index', methods: ['GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function index(StudentGroupsRepository $studentGroupsRepository,UserRepository $userRepository): Response
    {
        $groupList = $studentGroupsRepository->findAll();
        return $this->render('student_groups/index.html.twig', [
            'student_groups' => $groupList,
        ]);
    }

    #[Route('/new', name: 'app_student_groups_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_C')]
    public function new(Request $request, StudentGroupsRepository $studentGroupsRepository): Response
    {
        $studentGroup = new StudentGroups();
        $studentGroup->setDateStart(date_create('now')->modify('midnight'));
        $studentGroup->setDataEnd(date_create('now')->modify('last day of this month midnight'));
        $studentGroup->setName("Сгенерируется автоматически");
        $studentGroup->setCode("Сгенерируется автоматически");
        $form = $this->createForm(StudentGroupsType::class, $studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $code='';
            $code=$studentGroup->getFaculty()->getSpecialization()->getCode()."-".$studentGroup->getParallelNumber().'-'.(int)$studentGroup->getDateStart()->format("Y");
            $studentGroup->setCode($code);
            $name=$studentGroup->getCourseNumber().$studentGroup->getParallelNumber().$studentGroup->getFaculty()->getSpecialization()->getGroupSuffix();
            $studentGroup->setName($name);
            $studentGroupsRepository->save($studentGroup, true);

            return $this->redirectToRoute('app_student_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_groups/new.html.twig', [
            'student_group' => $studentGroup,
            'form' => $form,
        ]);
    }
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    #[Route('/{id}/show', name: 'app_student_groups_show', methods: ['GET'])]
    public function show(StudentGroups $studentGroup, StudentGroupsService $StudentGroupsService, StudentGroupsRepository $StudentGroupsRepository): Response
    {
        $studentGroup->getSocialPassport();
        return $this->render('student_groups/show.html.twig', [
            'student_group' => $studentGroup,
            'student_list'=> $studentGroup->getActiveStudents(),
        ]);
    }

    #[Route('/{id}/student-list', name: 'app_student_groups_show_students', methods: ['GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function show_students(StudentGroups $studentGroup): Response
    {
        $students=$studentGroup->getStudents();

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_student_groups_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_U')]
    public function edit(Request $request, StudentGroups $studentGroup, StudentGroupsRepository $studentGroupsRepository): Response
    {
        $form = $this->createForm(StudentGroupsType::class, $studentGroup);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentGroupsRepository->save($studentGroup, true);

            return $this->redirectToRoute('app_student_groups_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student_groups/edit.html.twig', [
            'student_group' => $studentGroup,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_student_groups_delete', methods: ['POST'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_D')]
    public function delete(Request $request, StudentGroups $studentGroup, StudentGroupsRepository $studentGroupsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $studentGroup->getId(), $request->request->get('_token'))) {
            $studentGroupsRepository->remove($studentGroup, true);
        }

        return $this->redirectToRoute('app_student_groups_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/generateListToElearning', name: 'app_student_groups_list_to_elearning', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function generateListToElearning(Request $request, StudentGroups $studentGroup): Response
    {
        return $this->studentGroupsService->generateElearningListToImport($studentGroup);
    }

    #[Route('/{id}/generateSchoolPortalList', name: 'app_student_groups_list_to_school_portal', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function generateSchoolPortalList(Request $request, StudentGroups $studentGroup): Response
    {
        return $this->studentGroupsService->generateSchoolPortalList($studentGroup);
    }

    #[Route('/{id}/generatePerCo', name: 'app_student_groups_list_to_PerCo', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function generatePerCo(Request $request, StudentGroups $studentGroup): Response
    {
        return $this->studentGroupsService->generatePerCo($studentGroup);
    }

    #[Route('/{id}/generateEnt', name: 'app_student_groups_list_to_ent', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function generateEnt(Request $request, StudentGroups $studentGroup): Response
    {
        return $this->studentGroupsService->generateEnt($studentGroup);
    }

    #[Route('/{id}/generateAccessCardList', name: 'app_student_groups_generate_access_card_list', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function generateAccessCardList(Request $request, StudentGroups $studentGroup): Response
    {
        $html = $this->renderView('_printtemplate.html.twig',
            [
                'content' => $this->typicalDocuments->generateSKUDRulesAccept($studentGroup)
            ]);
        $options = new Options();
        $options->set('defaultFont', '');

        $dompdf = new Dompdf($options);
        $options = $dompdf->getOptions();
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();

        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/{id}/generateAccessCardIssueList', name: 'app_student_groups_generate_access_issue_card_list', methods: ['POST', 'GET'])]
    #[IsGranted('ROLE_STAFF_STUDENT_GROUP_R')]
    public function generateAccessCardIssueList(Request $request, StudentGroups $studentGroup): Response
    {
     $html = $this->renderView('_printtemplate.html.twig',
            [
                'content' => $this->typicalDocuments->generateSKUDissue($studentGroup)
            ]);
        $options = new Options();
        $options->set('defaultFont', '');

        $dompdf = new Dompdf($options);
        $options = $dompdf->getOptions();
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4');
        $dompdf->render();

        return new Response (
            $dompdf->stream('resume', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    #[Route('/{id}/json', name: 'app_student_groups_json_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_GROUP_R")]
    public function json_index(Request $request, StudentRepository $studentRepository, StudentGroupsRepository $studentGroupsRepository, EventsListRepository $eventsListRepository): Response
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], $encoders);

        $result = array();
        foreach ($studentGroupsRepository->findAll() as $item) {
            $jsonarray = array();
            $jsonarray['id'] = $item->getId();
            $jsonarray['name'] = $item->getName();
            $result[] = $jsonarray;
        }
        $jsonContent = $serializer->serialize($result, 'json');

        $response = new Response($jsonContent);
        dd($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;

    }

    #[Route('/{id}/punishment-index', name: 'app_student_groups_punishment_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_GROUP_R")]
    public function punishmentIndex(StudentGroups $studentGroup): Response
    {
        $students = $studentGroup->getPunishmentsStudents();

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }


}
