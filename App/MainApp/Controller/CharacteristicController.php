<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\Characteristic;
use App\MainApp\Form\CharacteristicType;
use App\MainApp\Repository\CharacteristicRepository;
use App\MainApp\Repository\StudentRepository;
use App\MainApp\Service\CharacteristicGenerate;
use App\Controller\App\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/characteristic')]
#[IsGranted("ROLE_USER")]
class CharacteristicController extends AbstractController
{
    #[Route('/', name: 'app_characteristic_index', methods: ['GET'])]
    public function index(CharacteristicRepository $characteristicRepository): Response
    {
        return $this->render('characteristic/index.html.twig', [
            'characteristics' => $characteristicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_characteristic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CharacteristicRepository $characteristicRepository): Response
    {
        $characteristic = new Characteristic();
        $form = $this->createForm(CharacteristicType::class, $characteristic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $characteristicRepository->save($characteristic, true);

            return $this->redirectToRoute('app_characteristic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('characteristic/new.html.twig', [
            'characteristic' => $characteristic,
            'form' => $form,
        ]);
    }

    #[Route('/{studentid}/new', name: 'app_characteristic_new_for_student', methods: ['GET', 'POST'])]
    public function newForStudent(Request $request, CharacteristicRepository $characteristicRepository, StudentRepository $studentRepository): Response
    {
        $characteristic = new Characteristic();
        $request->attributes->all()['studentid'];
        $characteristic->setStudent($studentRepository->findOneBy(['id' => $request->attributes->all()['studentid']]));
        $characteristicRepository->save($characteristic);
        $characteristic->blockStudentEdit = true;
        $characteristic->ShowGenerator = false;

        $form = $this->createForm(CharacteristicType::class, $characteristic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $characteristicRepository->save($characteristic, true);

            return $this->redirectToRoute('app_characteristic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('characteristic/edit.html.twig', [
            'characteristic' => $characteristic,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_characteristic_show', methods: ['GET'])]
    public function show(Characteristic $characteristic): Response
    {
        return $this->render('characteristic/show.html.twig', [
            'characteristic' => $characteristic,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_characteristic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Characteristic $characteristic, CharacteristicRepository $characteristicRepository): Response
    {
        $form = $this->createForm(CharacteristicType::class, $characteristic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $characteristicRepository->save($characteristic, true);

            return $this->redirectToRoute('app_characteristic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('characteristic/edit.html.twig', [
            'characteristic' => $characteristic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/generate', name: 'app_characteristic_generate', methods: ['GET', 'POST'])]
    public function generate(Request $request, Characteristic $characteristic, CharacteristicRepository $characteristicRepository, CharacteristicGenerate $generate): Response
    {
        $characteristic->setContent($generate->CharacteristicGen($characteristic));
        $characteristicRepository->save($characteristic, true);
        return $this->redirectToRoute('app_characteristic_edit', ['id' => $characteristic->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/print', name: 'app_characteristic_print')]
    public function print(Request $request, Characteristic $characteristic, CharacteristicRepository $characteristicRepository, CharacteristicGenerate $generate)
    {

        if ($characteristic->checkValidationBool()) {
            return $this->render('characteristic/_print.html.twig', [
                'characteristic' => $characteristic,
            ]);

        } else {
            return $this->redirectToRoute('app_characteristic_show', ['id' => $characteristic->getId()], Response::HTTP_SEE_OTHER);
        }
    }

    #[
        Route('/{id}', name: 'app_characteristic_delete', methods: ['POST'])]
    public function delete(Request $request, Characteristic $characteristic, CharacteristicRepository $characteristicRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $characteristic->getId(), $request->request->get('_token'))) {
            $characteristicRepository->remove($characteristic, true);
        }

        return $this->redirectToRoute('app_characteristic_index', [], Response::HTTP_SEE_OTHER);
    }
}
