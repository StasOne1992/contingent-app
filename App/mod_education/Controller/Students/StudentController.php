<?php

namespace App\mod_education\Controller\Students;

use App\Controller\App\EduPart\Student\IsGranted;
use App\MainApp\Entity\Gender;
use App\MainApp\Entity\Person;
use App\MainApp\Entity\PersonDocument;
use App\MainApp\Entity\User;
use App\MainApp\Repository\CollegeRepository;
use App\MainApp\Repository\PersonRepository;
use App\MainApp\Repository\UserRepository;
use App\MainApp\Service\FileUploader;
use App\MainApp\Service\GlobalHelpersService;
use App\MainApp\Service\StudentService;
use App\mod_education\Entity\Student;
use App\mod_education\Entity\StudentGroup;
use App\mod_education\Form\StudentImportType;
use App\mod_education\Form\StudentType;
use App\mod_education\Repository\PersonalDocTypeListRepository;
use App\mod_education\Repository\StudentGroupsRepository;
use App\mod_education\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Npub\Gos\Snils;
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
    public function index(Request $request, StudentRepository $studentRepository, StudentGroupsRepository $studentGroupRepository): Response
    {

        //$studentGroupArray = $studentGroupRepository->findAll();
        //$students = $studentRepository->findBy(['StudentGroup' => $studentGroupArray, 'isActive' => true]);
        $students = $studentRepository->findAll();
        dd($students[0]->getFirstName());
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
        $person= new Person();
        $person->setBirthDate(date_create('1900-01-01'));
        $student->setPerson($person);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student->setUUID(uniqid());
            $this->em->persist($person);
            $this->em->flush();
            $studentRepository->save($student, true);
            return $this->redirectToRoute('app_student_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('student/new.html.twig', [
            'student' => $student,
            'form' => $form,
        ]);
    }

    #[Route('/import/{updateRecords}', name: 'app_student_import', requirements: ['updateRecords' => '\d+'], methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_IMP")]
    public function import(Request                       $request,
                           StudentRepository             $studentRepository,
                           FileUploader                  $fileUploader,
                           PersonalDocTypeListRepository $personalDocTypeListRepository,
                           StudentGroupsRepository       $studentGroupRepository,
                           bool                          $updateRecords = false): Response
    {
        $student = new Student();
        $form = $this->createForm(StudentImportType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            ini_set('max_execution_time', '300');
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
                $gender['MALE'] = $this->em->getRepository(Gender::class)->findOneBy(['genderName' => "MALE"]);
                $gender['FEMALE'] = $this->em->getRepository(Gender::class)->findOneBy(['genderName' => "FEMALE"]);
                $studentGroups = [];
                foreach ($this->em->getRepository(StudentGroup::class)->findAll() as $studentGroup) {
                    $studentGroups[$studentGroup->getCode()] = $studentGroup;
                }
                foreach ($lines as $line) {
                    $temparray = str_getcsv($line);
                    $personalDocuments = array();
                    if (array_key_exists(1, $temparray)) {
                        $row['first_name'] = $temparray[0];
                        $row['last_name'] = $temparray[1];
                        $row['middle_name'] = $temparray[2];
                        if ($temparray[3] == "Женщина") {
                            $row['gender_id'] = $gender['FEMALE']->getId();
                        } elseif ($temparray[] = "Мужчина") {
                            $row['gender_id'] = $gender['MALE']->getId();
                        }
                        $row['birth_date'] = date_create($temparray[4]);
                        $row['phone_number'] = $temparray[6];
                        $row['email'] = $temparray[7];
                        $row['address_fact'] = $temparray[8];
                        $row['address_main'] = $temparray[9];
                        $row['is_active'] = true;
                        $row['document_snils'] = Snils::createFromFormat($temparray[15]);
                        $row['document_medical_id'] = $temparray[16];
                        $row['document_passport_number'] = $temparray[10];
                        $row['document_passport_series'] = $temparray[11];
                        $row['document_passport_date'] = $temparray[14];
                        $row['document_passport_issue_organ'] = $temparray[13] . " (" . $temparray[12] . ")";
                        $row['student_group_id'] = $studentGroups[$temparray['5']];
                        $row['is_orphan'] = rand(0, 1);
                        $row['is_paid'] = rand(0, 1);
                        $row['is_invalid'] = rand(0, 1);
                        $row['is_poor'] = rand(0, 1);
                        $row['is_without_parents'] = rand(0, 1);
                        $row['is_live_student_accommodation'] = rand(0, 1);
                        $row['uuid'] = uniqid();
                        $row['number_zachetka'] = $temparray[7];
                        $row['number_stud_bilet'] = $temparray[8];
                        $row['family_type_id_id'] = $temparray[4];
                        $row['healtg_group_id_id'] = $temparray[5];
                        //$row['photo'] = $temparray[17];


                        /*$row['education_document_type'] = $temparray[27];
                        $row['edu_doc_series'] = $temparray[28];
                        $row['edu_doc_number'] = $temparray[29];
                        $row['edu_doc_issue_organ'] = $temparray[30];
                        $row['edu_doc_date'] = $temparray[31];
                        $row['edu_doc_reg_number'] = $temparray[32];
                        $row['avg_mark'] = $temparray[33];

                        $row['abiturient_petition_id'] = $temparray[35];
                        $row['first_password'] = $temparray[36];*/
                        $person;
                        if (count($CurrentPerson = $this->em->getRepository(Person::class)->findBySnils($row['document_snils'])) != 0) {
                            $person = $CurrentPerson[0];
                        } else {
                            $person = new Person();
                            $person->setFirstName($row['first_name']);
                            $person->setMiddleName($row['middle_name']);
                            $person->setLastName($row['last_name']);
                            $person->setSNILS($row['document_snils']);
                            $person->setBirthDate($row['birth_date']);
                            $person->setMedicalNumber($row['document_medical_id']);
                            $this->em->persist($person);
                            $this->em->flush();

                        }
                        dump($updateRecords);
                        $student;
                        if (!$person->getStudent()->isEmpty()) {
                            dump("NotEmpty");
                        } else if (!$person->getStudent()->isEmpty() && $updateRecords) {
                            dump("Not Empty. Need Update");
                        } else {
                            dump($row);
                            $student = new Student();
                            $student->setPerson($person);
                            $student->setAddressMain($row['address_main']);
                            $student->setAddressFact($row['address_fact']);
                            $student->setIsInvalid($row['is_invalid']);
                            $student->setIsLiveStudentAccommondation($row['is_live_student_accommodation']);
                            $student->setIsOrphan($row['is_orphan']);
                            $student->setIsPaid($row['is_paid']);
                            $student->setIsPoor($row['is_poor']);
                            $student->setIsWithoutParents($row['is_without_parents']);
                            $student->setUUID(uniqid());

                            if ($row['document_passport_series'] &&
                                $row['document_passport_number'] &&
                                $row['document_passport_date'] &&
                                $row['document_passport_issue_organ']) {
                                if (count($this->em->getRepository(PersonDocument::class)->findBy(['series' => $row['document_passport_series'], 'number' => $row['document_passport_number']])) == 0) {
                                    $passport = new PersonDocument();
                                    $passport->setPerson($person);
                                    $passport->setIssueDate(date_create($row['document_passport_date']));
                                    $passport->setSeries($row['document_passport_series']);
                                    $passport->setNumber($row['document_passport_number']);
                                    $passport->setIssueOrgan($row['document_passport_issue_organ']);
                                    $passport->setNote('AutomaticImport');
                                    $passport->setActived(true);
                                    dump('newPassport', $passport);
                                    $this->em->persist($passport);
                                    $this->em->flush();
                                } else {
                                    dump('InTheDatabase');
                                }
                            }
                            $user = new User();
                            $user ->setIsStudent(true);
                            $user->setCollege($studentGroup->getCollege());
                            $user->setRoles(["ROLE_STUDENT"]);
                            $user->setPassword('default');
                            $student->setUser($user);
                            $student->setPhoneNumber($row['phone_number']);
                            $student->setIsActive(true);
                            $this->em->persist($student);
                            $this->em->persist($user);
                            $this->em->flush();
                            $students[] = $student;
                            dump($student, "Empty");
                        }
                        /*$studentGroup = $studentGroupRepository->findBy(['Code' => $row['student_group_id']]);
                             dump($row['student_group_id'], $studentGroup)*/
                    }
                }
                return $this->render('student/_import_form.html.twig', ['student' => $students,
                ]);
            }
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
       // $student->getContingentDocuments()->getValues();
      //  $student->getEventsResults();
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
                    $group = new StudentGroup();
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
                $group = new StudentGroup();
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
    public function setGroup(Request $request, Student $student, StudentRepository $studentRepository, StudentGroupsRepository $studentGroupRepository): Response
    {
        $student->setStudentGroup($studentGroupRepository->find($request->get('group-select')));
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
