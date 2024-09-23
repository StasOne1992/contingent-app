<?php

namespace App\MainApp\Controller\EduPart;

use App\MainApp\Entity\ContingentDocument;
use App\MainApp\Entity\GroupMembership;
use App\MainApp\Form\ContingentDocumentForm;
use App\MainApp\Repository\CollegeRepository;
use App\MainApp\Repository\ContingentDocumentRepository;
use App\MainApp\Repository\StudentGroupsRepository;
use App\MainApp\Repository\StudentRepository;
use App\MainApp\Service\TypicalDocuments;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/contingent/document')]
#[IsGranted("ROLE_USER")]
class ContingentDocumentController extends AbstractController
{

    public function __construct()
    {
        dump('Потребление памяти в конструкторе', memory_get_usage());
    }

    #[Route('/', name: 'app_contingent_document_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_R")]
    public function index(ContingentDocumentRepository $contingentDocumentRepository) : Response
    {

        return $this->render('contingent_document/index.html.twig', [
            'contingent_documents' => $contingentDocumentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_contingent_document_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_C")]
    public function new(Request $request, ContingentDocumentRepository $contingentDocumentRepository): Response
    {
        $contingentDocument = new ContingentDocument();
        $form = $this->createForm(ContingentDocumentForm::class, $contingentDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contingentDocumentRepository->save($contingentDocument, true);
            return $this->redirectToRoute('app_contingent_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contingent_document/new.html.twig', [
            'contingent_document' => $contingentDocument,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_contingent_document_show', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_R")]
    public function show(ContingentDocument $contingentDocument, ContingentDocumentRepository $contingentDocumentRepository): Response
    {
        $contingentDocument->getStudent()->getValues();
        return $this->render('contingent_document/show.html.twig', [
            'contingent_document' => $contingentDocument,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contingent_document_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_U")]
    public function edit(Request $request, ContingentDocument $contingentDocument, ContingentDocumentRepository $contingentDocumentRepository,StudentGroupsRepository $studentGroupsRepository): Response
    {
        $form = $this->createForm(ContingentDocumentForm::class, $contingentDocument);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //dd($form->getData());
            $contingentDocumentRepository->save($contingentDocument, true);

            return $this->redirectToRoute('app_contingent_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contingent_document/edit.html.twig', [
            'contingent_document' => $contingentDocument,
            'form' => $form,
            'studentGroups'=>$studentGroupsRepository->findAll(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_contingent_document_delete', methods: ['POST'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_D")]
    public function delete(Request $request, ContingentDocument $contingentDocument, ContingentDocumentRepository $contingentDocumentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contingentDocument->getId(), $request->request->get('_token'))) {
            $contingentDocumentRepository->remove($contingentDocument, true);
        }

        return $this->redirectToRoute('app_contingent_document_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/print', name: 'app_contingent_document_print')]
    #[IsGranted("ROLE_STAFF_CONT_DOC_PRINT")]
    public function print(Request $request, ContingentDocument $contingentDocument, ContingentDocumentRepository $contingentDocumentRepository, TypicalDocuments $typicalDocuments, CollegeRepository $collegeRepository){
        $contingentDocument->getStudent()->getValues();
        $collegeRepository->findBy(['id'=>$contingentDocument->getCollege()->getId()]);

        $html =  $this->renderView('_printtemplate.html.twig',
            [
                'content' => $typicalDocuments->generateOrder($contingentDocument)
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

    #[Route ('/{id}/putToUse', name: 'app_contingent_document_put_into_use', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_U")]
    public function putIntoUse(Request $request, ContingentDocument $contingentDocument, EntityManagerInterface $entityManager, ContingentDocumentRepository $contingentDocumentRepository, StudentRepository $studentRepository)
    {
        set_time_limit(300);
        $membership = $contingentDocument->getGroupMemberships()->getValues();
        if (count($membership) == 0) {
            foreach ($contingentDocument->getStudent()->getValues() as $student)
            {
                $ms = new GroupMembership();
                $ms->setStudent($student);
                $ms->setContingentDocument($contingentDocument);
                $ms->setStudentGroup($student->getStudentGroup());
                $ms->setDateStart($contingentDocument->getCreateDate());
                $entityManager->persist($ms);
            }
        } else {
            foreach ($contingentDocument->getStudent()->getValues() as $student) {
                foreach ($membership as $item) {
                    /***
                     * @var GroupMembership $item
                     */
                    if (($item->getStudent() != $student) or ($item->getStudent() == null)) {
                        $ms = new GroupMembership();
                        $ms->setStudent($student);
                        $ms->setContingentDocument($contingentDocument);
                        $ms->setStudentGroup($student->getStudentGroup());
                        $ms->setDateStart($contingentDocument->getCreateDate());
                        $ms->setActive(true);
                        $entityManager->persist($ms);

                    }
                }
            }
        }
        $contingentDocument->setIsActive(true);
        $entityManager->persist($contingentDocument);
        $entityManager->flush();


        return $this->redirect($request->headers->get('referer'),301);
    }

    #[Route ('/{id}/putOutUse', name: 'app_contingent_document_put_out_use', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_U")]
    public function putOutUse()
    {

    }

    #[Route ('/setStudents/{id}', name: 'app_contingent_document_set', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_CONT_DOC_U")]
    public function setstudent(ContingentDocumentRepository $contingentDocumentRepository, StudentRepository $studentRepository)
    {
        $contingentDocumentId = $_POST['contingent_document_id'];
        $contingentDocument = $contingentDocumentRepository->findOneBy(['id' => $contingentDocumentId]);


        foreach ($_POST as $item => $value) {
            if (str_starts_with($item,'row')) {
                $student=$studentRepository->findOneBy(['id'=>$value]);
                $contingentDocument->addStudent($student);
            }
        }
        $contingentDocumentRepository->save($contingentDocument,true);
        return $this->redirectToRoute('app_contingent_document_edit', ['id'=>$contingentDocumentId], Response::HTTP_SEE_OTHER);
    }

}
