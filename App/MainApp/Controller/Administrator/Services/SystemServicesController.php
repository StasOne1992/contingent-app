<?php

namespace App\MainApp\Controller\Administrator\Services;

use App\MainApp\Entity\SystemServices;
use App\MainApp\Form\SystemServicesType;
use App\MainApp\Repository\SystemServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('administrator/system/services')]
#[IsGranted("ROLE_ROOT")]
class SystemServicesController extends AbstractController
{
    #[Route('/', name: 'app_system_services_index', methods: ['GET'])]
    public function index(SystemServicesRepository $SystemServicesRepository): Response
    {
        return $this->render('administrator/system_services/index.html.twig', [
            'system_services' => $SystemServicesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_system_services_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ROOT")]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $systemService = new SystemServices();
        $form = $this->createForm(SystemServicesType::class, $systemService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($systemService);
            $entityManager->flush();

            return $this->redirectToRoute('app_system_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('administrator/system_services/new.html.twig', [
            'system_serivce' => $systemService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_system_services_show', methods: ['GET'])]
    #[IsGranted("ROLE_ROOT")]
    public function show(Systemservices $systemSerivce): Response
    {
        return $this->render('administrator/system_services/show.html.twig', [
            'system_serivce' => $systemSerivce,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_system_services_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_ROOT")]
    public function edit(Request $request, Systemservices $systemSerivce, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SystemservicesType::class, $systemSerivce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_system_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('administrator/system_services/edit.html.twig', [
            'system_serivce' => $systemSerivce,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_system_services_delete', methods: ['POST'])]
    #[IsGranted("ROLE_ROOT")]
    public function delete(Request $request, Systemservices $systemSerivce, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $systemSerivce->getId(), $request->request->get('_token'))) {
            $entityManager->remove($systemSerivce);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_system_services_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/status', name: 'app_system_services_status', methods: ['GET'])]
    #[IsGranted("ROLE_ROOT")]
    public function status(Systemservices $systemSerivce): Response
    {
        $process = new Process(['systemctl', 'status', $systemSerivce->getSystemName()]);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $result = new Response();
        $result->setContent($process->getOutput());
        $process->stop();
        return $result;
    }

    #[Route('/{id}/start', name: 'app_system_services_start', methods: ['GET'])]
    #[IsGranted("ROLE_ROOT")]
    public function start(Systemservices $systemSerivce): Response
    {
        $process = new Process(['su','systemctl', 'start', $systemSerivce->getSystemName()]);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $result = new Response();
        $result->setContent($process->getOutput());
        $process->stop();
        return $result;
    }

    #[Route('/{id}/stop', name: 'app_system_services_stop', methods: ['GET'])]
    #[IsGranted("ROLE_ROOT")]
    public function stop(Systemservices $systemSerivce): Response
    {
        $process = new Process(['systemctl','stop', $systemSerivce->getSystemName()]);
        $process->setTimeout(3600);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $result = new Response();
        $result->setContent($process->getOutput());
        $process->stop();
        return $result;
    }
}
