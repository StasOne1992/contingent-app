<?php

namespace App\MainApp\Controller\Admission;

use App\Controller\App\Admission\IsGranted;
use App\MainApp\Entity\Admission;
use App\MainApp\Form\AdmissionType;
use App\MainApp\Repository\AdmissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/admission/admissions')]
#[IsGranted("ROLE_USER")]
class AdmissionController extends AbstractController
{
    #[Route('/', name: 'app_admission_index', methods: ['GET'])]
    public function index(AdmissionRepository $admissionRepository): Response
    {
        return $this->render('admission/index.html.twig', [
            'admissions' => $admissionRepository->findAll(),
        ]);
    }

    #[Route('/push', name: 'app_admission_push', methods: ['GET', 'POST'])]
    public function push(HubInterface $hub): Response
    {
        $topics = 'popup-notify';
        $type='danger';
        $icon= ' fa fa-check me-1 ';//icon class full
        $header = 'Заголовок';
        $message = 'Текст сообщения';
        $update = new Update(
            $topics,
            json_encode([ 'type'=>$type,'header' => $header,'icon'=>$icon, 'message' => $message])
        );
        $hub->publish($update);

       return new Response('published!');

    }

    #[
        Route('/new', name: 'app_admission_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AdmissionRepository $admissionRepository): Response
    {
        $admission = new Admission();
        $form = $this->createForm(AdmissionType::class, $admission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionRepository->save($admission, true);

            return $this->redirectToRoute('app_admission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission/new.html.twig', [
            'admission' => $admission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_admission_show', methods: ['GET'])]
    public function show(Admission $admission): Response
    {
        return $this->render('admission/show.html.twig', [
            'admission' => $admission,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admission_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Admission $admission, AdmissionRepository $admissionRepository): Response
    {
        $form = $this->createForm(AdmissionType::class, $admission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admissionRepository->save($admission, true);

            return $this->redirectToRoute('app_admission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admission/edit.html.twig', [
            'admission' => $admission,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_admission_delete', methods: ['POST'])]
    public function delete(Request $request, Admission $admission, AdmissionRepository $admissionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $admission->getId(), $request->request->get('_token'))) {
            $admissionRepository->remove($admission, true);
        }

        return $this->redirectToRoute('app_admission_index', [], Response::HTTP_SEE_OTHER);
    }
}
