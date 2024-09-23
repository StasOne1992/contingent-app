<?php

namespace App\MainApp\Controller\EduPart\Student;

use App\Controller\App\EduPart\Student\IsGranted;
use App\MainApp\Entity\Person;
use App\MainApp\Entity\PersonalDocuments;
use App\MainApp\Entity\Staff;
use App\MainApp\Entity\Student;
use App\MainApp\Entity\StudentGroups;
use App\MainApp\Entity\User;
use App\MainApp\Form\EduPart\StudentImportType;
use App\MainApp\Form\EduPart\StudentType;
use App\MainApp\Repository\CollegeRepository;
use App\MainApp\Repository\PersonalDocTypeListRepository;
use App\MainApp\Repository\PersonRepository;
use App\MainApp\Repository\StudentGroupsRepository;
use App\MainApp\Repository\StudentRepository;
use App\MainApp\Repository\UserRepository;
use App\MainApp\Service\FileUploader;
use App\MainApp\Service\GlobalHelpersService;
use App\MainApp\Service\StudentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use function PHPUnit\Framework\isNull;

////use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/student')]
class StudentController extends AbstractController
{
    private EntityManagerInterface $em;
    private StudentService $studentService;

    public function __construct(
        StudentService         $studentService,
        EntityManagerInterface $em,
    )
    {
        $this->studentService = $studentService;
        $this->em = $em;
    }

    #[Route('/index', name: 'app_student_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_R")]
    public function index(Request $request, StudentRepository $studentRepository, StudentGroupsRepository $studentGroupsRepository): Response
    {
        $studentGroupArray = $studentGroupsRepository->findAll();
        $students = $studentRepository->findBy(['StudentGroup' => $studentGroupArray, 'isActive' => true]);
        usort($students, function ($a, $b) {
            /***
             * @var Student $a
             * @var Student $b
             *
             */
            if ($a->getLastName() == $b->getLastName()) {
                return 0;
            }
            elseif ($a->getLastName() < $b->getLastName())
            {
                return ($a->getLastName() < $b->getLastName()) ? -1 : 1;
            }
                return ($a->getLastName() < $b->getLastName()) ? -1 : 1;
        });

        return $this->render('student/index.html.twig', [
            'students' => $students,
        ]);
    }

    #[Route('/new', name: 'app_student_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_C")]
    public function new(Request $request, StudentRepository $studentRepository): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student->setUUID(uniqid());
            $studentRepository->save($student, true);
            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/import', name: 'app_student_import', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_IMP")]
    public function import(Request $request, StudentRepository $studentRepository, FileUploader $fileUploader, PersonalDocTypeListRepository $personalDocTypeListRepository, StudentGroupsRepository $studentGroupsRepository): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentImportType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('brochure')->getData();
            if ($brochureFile) {
                $brochureFileName = $fileUploader->upload($brochureFile);
                $fileName = new File($this->getParameter('student_import_directory') . '/' . $brochureFileName);
                $csvData = file_get_contents($fileName);
                $lines = explode(PHP_EOL, $csvData);
                $students = array();
                $personaDocument = array();
                unset($lines[0]);
                foreach ($lines as $line) {
                    $temparray = str_getcsv($line);
                    $personalDocuments=array();
                    if (array_key_exists(1, $temparray)) {
                        $row['id'] = $temparray[0];
                        $row['first_name'] = $temparray[1];
                        $row['last_name'] = $temparray[2];
                        $row['middle_name'] = $temparray[3];
                        $row['family_type_id_id'] = $temparray[4];
                        $row['healtg_group_id_id'] = $temparray[5];
                        $row['gender_id'] = $temparray[6];
                        $row['number_zachetka'] = $temparray[7];
                        $row['number_stud_bilet'] = $temparray[8];
                        $row['birth_data'] = $temparray[9];
                        $row['phone_number'] = $temparray[10];
                        $row['email'] = $temparray[11];
                        $row['document_snils'] = $temparray[12];
                        $row['document_medical_id'] = $temparray[13];
                        $row['address_fact'] = $temparray[14];
                        $row['address_main'] = $temparray[15];
                        $row['is_active'] = $temparray[16];
                        $row['photo'] = $temparray[17];
                        $row['student_group_id'] = $temparray[18];
                        $row['is_orphan'] = $temparray[19];
                        $row['is_paid'] = $temparray[20];
                        $row['is_invalid'] = $temparray[21];
                        $row['is_poor'] = $temparray[22];
                        $row['pasport_number'] = $temparray[23];
                        $row['pasport_series'] = $temparray[24];
                        $row['pasport_date'] = $temparray[25];
                        $row['pasport_issue_organ'] = $temparray[26];
                        $row['education_document_type'] = $temparray[27];
                        $row['edu_doc_series'] = $temparray[28];
                        $row['edu_doc_number'] = $temparray[29];
                        $row['edu_doc_issue_organ'] = $temparray[30];
                        $row['edu_doc_date'] = $temparray[31];
                        $row['edu_doc_reg_number'] = $temparray[32];
                        $row['avg_mark'] = $temparray[33];
                        $row['is_without_parents'] = $temparray[34];
                        $row['abiturient_petition_id'] = $temparray[35];
                        $row['first_password'] = $temparray[36];
                        $row['uuid'] = $temparray[37];
                        $row['is_live_student_accommondation'] = $temparray[38];

                        $thisStudent = $studentRepository->findBy(['DocumentSnils' => $row['document_snils']]);
                        if (!is_null($thisStudent)) {
                            dump($thisStudent);
                        } else {
                            $student = new Student();
                            $student->setFirstName($row['first_name']);
                            $student->setLastName($row['last_name']);
                            $student->setMiddleName($row['middle_name']);
                            $student->setAddressMain($row['address_main']);
                            $student->setAddressFact($row['address_fact']);
                            $student->setBirthDate(new \DateTime(date("d M Y", date(strtotime($row['birth_data'])))));
                            $student->setDocumentSnils($row['document_snils']);
                            $student->setPasportSeries($row['pasport_series']);
                            $student->setPasportNumber($row['pasport_number']);
                            $student->setPasportIssueOrgan($row['pasport_issue_organ']);
                            $student->setIsActive(true);
                            $student->setPasportDate(new \DateTime(date("d M Y", date(strtotime($row['pasport_date'])))));
                            $studentGroup = $studentGroupsRepository->findBy(['Code' => $row['student_group_id']]);
                            dump($row['student_group_id'], $studentGroup);

                            $students[] = $student;
                            $attestat = new PersonalDocuments();
                            $attestat->setStudent($student);
                            $docType = $personalDocTypeListRepository->findOneby(['Title' => $row['education_document_type']]);
                            $attestat->setDocumentType($docType);
                            $attestat->setDocumentNumber($row['edu_doc_number']);
                            $attestat->setDocumentSeries($row['edu_doc_series']);
                            $attestat->setDocumentOfficialSeal($row['edu_doc_issue_organ']);
                            $attestat->setDocumentIssueDate(new \DateTime(date("d M Y", date(strtotime($row['edu_doc_date'])))));
                            $personalDocuments[] = $attestat;
                        }
                    }
                }
            }
            dd($students, $personalDocuments);
            return $this->render('student/_import_form.html.twig', [
                'students' => $students,
            ]);
        }
        return $this->render('student/import.html.twig', ['student' => $student,
            'form' => $form,]);

    }

    #[Route('/{id}/show', name: 'app_student_show', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_R")]
    public function show(Student $student): Response
    {
        $student->getPersonalDocuments()->getValues();
        $student->getCharacteristics()->getValues();
        $student->getLegalRepresentatives()->getValues();
        $student->getContingentDocuments()->getValues();
        $student->getEventsResults();
        $student->getStudentPunishments()->getValues();
            return $this->render('student/show.html.twig', [
                'student' => $student,
            ]);

        return $this->redirectToRoute('app_access_denied', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/edit', name: 'app_student_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_U")]
    public function edit(Request $request, Student $student, StudentRepository $studentRepository): Response
    {


        if (($this->getUser()->getStaff()) && !(($this->isGranted('ROLE_ROOT')) || $this->isGranted('ROLE_ADMIN'))) {
            /**
             * @var Staff $staff
             * @var User $user
             */
            $user = $this->getUser();
            $studentGroupArray = $user->getStaff()->getStudentGroups()->getValues();
            $studentGroupIdArray = array();
            foreach ($studentGroupArray as $group) {
                $studentGroupIdArray[] = $group->getId();
            }
            if (in_array($student->getStudentGroup()->getId(), $studentGroupIdArray)) {
                $form = $this->createForm(StudentType::class, $student);
                $form->handleRequest($request);
                if (!$student->getStudentGroup()) {
                    $group = new StudentGroups();
                    $group->setName("Группа не указана");
                    $student->setStudentGroup($group);
                }

                if ($form->isSubmitted() && $form->isValid()) {
                    $studentRepository->save($student, true);
                    return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
                }

                return $this->render('student/edit.html.twig', [
                    'student' => $student,
                    'form' => $form,
                ]);
            }
        } elseif (($this->getUser()->getStaff()) && (($this->isGranted('ROLE_ROOT')) || $this->isGranted('ROLE_ADMIN'))) {
            $form = $this->createForm(StudentType::class, $student);
            $form->handleRequest($request);
            if (!$student->getStudentGroup()) {
                $group = new StudentGroups();
                $group->setName("Группа не указана");
                $student->setStudentGroup($group);
            }

            if ($form->isSubmitted() && $form->isValid()) {
                $studentRepository->save($student, true);
                return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('student/edit.html.twig', [
                'student' => $student,
                'form' => $form,
            ]);
        }
        return $this->redirectToRoute('app_access_denied', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/setGroup', name: 'app_student_setGroup', methods: ['POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_U")]
    public function setGroup(Request $request, Student $student, StudentRepository $studentRepository, StudentGroupsRepository $studentGroupsRepository): Response
    {
        $student->setStudentGroup($studentGroupsRepository->find($request->get('group-select')));
        $studentRepository->save($student, true);
        return new Response(
            $student->getStudentGroup(),
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        //return $this->redirectToRoute('app_contingent_document_edit', ['id'=>$request->get('contingentDocumentID')], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/delete', name: 'app_student_delete', methods: ['POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_D")]
    public function delete(Request $request, Student $student, StudentRepository $studentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $student->getId(), $request->request->get('_token'))) {
            $studentRepository->remove($student, true);
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/filluuid', name: 'app_student_fillUUID', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_U")]
    public function fillUUID()
    {
        $this->studentService->fillStudentsUUID();
        return new Response();
    }


    #[Route('/fillemail', name: 'fillEmail', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_U")]
    public function fillEmail()
    {
        $this->studentService->fillStudentsEmails();
        return new Response();
    }

    #[Route('/create_persona', name: 'app_abiturient_petition_create_persona', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_U")]
    public function createPersona(StudentRepository $studentRepository, PersonRepository $personRepository): Response
    {
        //throw new AccessDeniedException('Only an admin can do this!!!!');
        $this->em->getRepository(Person::class);

        /**
         * @var Student $item
         */
        foreach ($studentRepository->findBy(['person' => null]) as $item) {
            if (count($finded = $personRepository->findBy(['SNILS' => $item->getDocumentSnils()])) == 0) {
                $person = new Person();
                //dump('studentid:'.$item->getId(),'studentSNILS:'.$item->getDocumentSnils());
                if (isNull($item->getDocumentSnils()) or $item->getDocumentSnils() == '') {
                    $person->setSNILS($item->getUUID());
                    $item->setDocumentSnils($item->getUUID());
                } else {
                    $person->setSNILS($item->getDocumentSnils());
                }
                $person->setFirstName($item->getFirstName());
                $person->setLastName($item->getLastName());
                $person->setMiddleName($item->getMiddleName());
                $person->setMedicalNumber($item->getDocumentMedicalID());
                //dump("person: ".$person->getSNILS()." stud:".$item->getDocumentSnils());
                $this->em->persist($person);
                $this->em->flush();
                $item->setPerson($person);
                $studentRepository->save($item, true);
            } else {
                $item->setPerson($finded[0]);
                $studentRepository->save($item, true);
            }
            //dump($item,$item->getPerson());

        }
        //dd('');
        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/createUsers', name: 'app_student_createusers', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_U")]
    public function createusers(Request $request, StudentRepository $studentRepository, UserRepository $userRepository, GlobalHelpersService $globalHelpersService, UserPasswordHasherInterface $passwordHasher, CollegeRepository $collegeRepository): Response
    {
        if ($studentRepository->findAll()) {
            /***
             * @var Student $student
             */

            foreach ($studentRepository->findAll() as $student) {

                if ($student->getUsers()->isEmpty()) {
                    $user = new User();
                    $college = $collegeRepository->find(1);//ToDo: Написать метод для поиска колледжа
                    $genEmail=$globalHelpersService->translit($student->getLastName() . mb_substr($student->getFirstName(),0,1) .  mb_substr($student->getMiddleName(),0,1).'@' . $college->getSettingsStudentsDomain());
                    $user->setEmail($genEmail);
                    $genPass = $globalHelpersService->gen_password(10);
                    $password = $passwordHasher->hashPassword($user, $genPass);
                    $user->setPassword($password);
                    $user->setIsStudent();
                    $user->setStudent($student);
                    $user->setRoles(['ROLE_STUDENT']);
                    $student->setEmail($genEmail);
                    $studentRepository->save($student,true);
                    $userRepository->save($user,true);
                }
            }
        }

        return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
    }


}
