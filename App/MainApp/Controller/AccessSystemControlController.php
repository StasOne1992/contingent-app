<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\AccessSystemControl;
use App\MainApp\Form\AccessSystemControlType;
use App\MainApp\Repository\AccessSystemControlRepository;
use App\MainApp\Repository\StudentRepository;
use App\MainApp\Service\RFIDService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/asc')]
#[IsGranted("ROLE_USER")]
class AccessSystemControlController extends AbstractController
{
    public function __construct(
        private StudentRepository             $studentRepository,
        private AccessSystemControlRepository $accessSystemControlRepository,
        private RFIDService                   $RFIDService,
    )
    {
    }

    #[Route('/', name: 'app_access_system_control_index', methods: ['GET'])]
    public function index(AccessSystemControlRepository $accessSystemControlRepository): Response
    {
        return $this->render('access_system_control/index.html.twig', [
            'access_system_controls' => $accessSystemControlRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_access_system_control_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $accessSystemControl = new AccessSystemControl();

        if ($request->get('studentID') and $request->get('CardSeries')) {
            $accessSystemControl->setStudent($this->studentRepository->find($request->get('studentID')));
            $accessSystemControl->setAccesCardNumber($request->get('CardNumber'));
            $accessSystemControl->setAccessCardSeries($request->get('CardSeries'));
            $accessSystemControl->setIssueDate(new DateTime('now'));
            $entityManager->persist($accessSystemControl);
            $entityManager->flush();
            if ($request->get('lockID')) {
                foreach ($request->get('lockID') as $card) {
                    $this->lockCard($card, $entityManager);
                }
            }
            return $this->redirectToRoute('app_student_show', ['id' => $request->get('studentID')], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(AccessSystemControlType::class, $accessSystemControl);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($accessSystemControl);
            $entityManager->flush();

            return $this->redirectToRoute('app_access_system_control_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('access_system_control/new.html.twig', [
            'access_system_control' => $accessSystemControl,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/show', name: 'app_access_system_control_show', methods: ['GET'])]
    public function show(AccessSystemControl $accessSystemControl): Response
    {
        $convertString=$this->RFIDService->convert('hid',$accessSystemControl->getAccessCardSeries().','.$accessSystemControl->getAccesCardNumber());

        return $this->render('access_system_control/show.html.twig', [
            'access_system_control' => $accessSystemControl,
            'convertString'=>$convertString,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_access_system_control_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AccessSystemControl $accessSystemControl, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AccessSystemControlType::class, $accessSystemControl);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_access_system_control_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('access_system_control/edit.html.twig', [
            'access_system_control' => $accessSystemControl,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/lock', name: 'app_access_system_control_lock', methods: ['GET', 'POST'])]
    public function lock(Request $request, AccessSystemControl $accessSystemControl, EntityManagerInterface $entityManager): Response
    {
        $accessSystemControl->setIsLocked(true);
        $accessSystemControl->setLockDate(new DateTime('now'));
        $entityManager->flush();
        return $this->redirectToRoute('app_access_system_control_edit', ['id' => $accessSystemControl->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param AccessSystemControl $accessSystemControl
     * @param EntityManagerInterface $entityManager
     * @return void
     */
    private function lockCard($accessSystemControl, $entityManager)
    {

        $accessSystemControl = $this->accessSystemControlRepository->find($accessSystemControl);
        $accessSystemControl->setIsLocked(true);
        $accessSystemControl->setLockDate(new DateTime('now'));
        $entityManager->persist($accessSystemControl);
        $entityManager->flush();

    }

    #[Route('/{id}/delete', name: 'app_access_system_control_delete', methods: ['POST'])]
    public function delete(Request $request, AccessSystemControl $accessSystemControl, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $accessSystemControl->getId(), $request->request->get('_token'))) {
            $entityManager->remove($accessSystemControl);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_access_system_control_index', [], Response::HTTP_SEE_OTHER);
    }
}
