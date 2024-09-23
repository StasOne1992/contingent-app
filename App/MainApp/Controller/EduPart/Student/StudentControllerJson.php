<?php

namespace App\MainApp\Controller\EduPart\Student;

use App\MainApp\Entity\Student;
use App\MainApp\Repository\EventsListRepository;
use App\MainApp\Repository\StudentGroupsRepository;
use App\MainApp\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


#[Route('/student/json')]
class StudentControllerJson extends AbstractController
{

    #[Route('/index', name: 'app_student_json_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_R")]
    public function json_index(Request $request, StudentRepository $studentRepository, StudentGroupsRepository $studentGroupsRepository, EventsListRepository $eventsListRepository): Response
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();

        $students = array();
        if ($request->get('requestType')) {
            $requestType = $request->get('requestType');
            if ($requestType == "EventList" && $request->get('event')) {
                $event = $eventsListRepository->find($request->get('event'));
                $eventStudent = $event->getEventsResults();
                $students = $studentRepository->findAll();
                foreach ($students as $key => $student) {

                    foreach ($eventStudent as $item) {

                        if ($item->getStudent() == $student) {

                            unset($students[$key]);
                        }
                    }
                }
                foreach ($event->getEventsResults() as $value) {
                    $value->getStudent()->getAsJson();
                }
            } else {
                $students = $studentRepository->findAll();

            }

        } else
            $students = $studentRepository->findAll();


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function (object $object, string $format, array $context): string {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $serializer = new Serializer([$normalizer], $encoders);

        $result = array();

        foreach ($students as $student) {
            $result[] = $student->getAsJson();

            $normalizers = [new ObjectNormalizer()];
            $serializer = new Serializer($normalizers);

            dd($serializer->normalize($student));
            dd($student->getAsJson());
        }
        $jsonContent = $serializer->serialize($result, 'json');

        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    #[Route('/{id}', name: 'app_student_json', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_R")]
    public function json_student(Student $student, Request $request, StudentRepository $studentRepository, StudentGroupsRepository $studentGroupsRepository, EventsListRepository $eventsListRepository): Response
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
        $jsonContent = $serializer->serialize($student->getAsJson(), 'json');
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }



}