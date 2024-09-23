<?php

namespace App\mod_mosregvis\Controller;

use App\mod_mosregvis\Entity\modMosregVis;
use App\mod_mosregvis\Form\modmosregvisType;
use App\mod_mosregvis\Repository\modMosregVisRepository;
use App\mod_mosregvis\Service\ModMosregApiOpenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Config\Definition\Exception\Exception;
use function PHPUnit\Framework\isEmpty;

#[Route('/mod_mosregvis')]
#[IsGranted("ROLE_USER")]
class modmosregvisController extends AbstractController
{
    #[Route('/index', name: 'mod_mosregvis_index', methods: ['GET'])]
    public function index(modMosregVisRepository $modMosregVisRepository): Response
    {
        return $this->render('@mod_mosregvis/index.html.twig',
            [
                'modMosregVis' => $modMosregVisRepository->findAll()
            ]
        );
    }

    #[Route('/new', name: 'mod_mosregvis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, modMosregVisRepository $modMosregVisRepository): Response
    {
        $modmosregvis = new modMosregVis();
        $form = $this->createForm(modmosregvisType::class, $modmosregvis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($modmosregvis);
            $entityManager->flush();

            return $this->redirectToRoute('mod_mosregvis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@mod_mosregvis\new.html.twig', [
            'education_plan' => $modmosregvis,
            'form' => $form,
        ]);
    }

    #[Route('{id}/edit', name: 'mod_mosregvis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ModMosregVis $modMosregVis, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(modmosregvisType::class, $modMosregVis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($modMosregVis);
            $entityManager->flush();

            return $this->redirectToRoute('mod_mosregvis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('@mod_mosregvis/edit.html.twig', [
            'modMosregVis' => $modMosregVis,
            'form' => $form,
        ]);
    }

    #[Route('/getorgidfromvis', name: 'mod_mosregvis_getorgidfromvis', methods: ['GET','POST'])]
    public function mod_mosregvis_getorgidfromvis(Request $request, modMosregVisRepository $modMosregVisRepository, ModMosregApiOpenService $modMosregApiOpenService): Response
    {
        $response = new Response();
        if (is_null($request->getContent())) {
            $requestData = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
            $responseData = $modMosregApiOpenService->getOrgIdByUser($requestData['username'], $requestData['password']);
            $response->setContent($responseData);
        }
        else     throw new Exception("Ошибка. Не заданы параметры для запроса. Код ошибки: 0xf054");

        return $response;
    }


}