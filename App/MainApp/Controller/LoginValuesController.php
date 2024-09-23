<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\LoginValues;
use App\MainApp\Form\LoginValuesType;
use App\MainApp\Repository\LoginValuesRepository;
use App\Controller\App\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/login/values')]
#[IsGranted("ROLE_USER")]
class LoginValuesController extends AbstractController
{
    #[Route('/', name: 'app_login_values_index', methods: ['GET'])]
    public function index(LoginValuesRepository $loginValuesRepository): Response
    {
        return $this->render('login_values/index.html.twig', [
            'login_values' => $loginValuesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_login_values_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $loginValue = new LoginValues();
        $form = $this->createForm(LoginValuesType::class, $loginValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($loginValue);
            $entityManager->flush();

            return $this->redirectToRoute('app_login_values_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('login_values/new.html.twig', [
            'login_value' => $loginValue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/show', name: 'app_login_values_show', methods: ['GET'])]
    public function show(LoginValues $loginValue): Response
    {
        return $this->render('login_values/show.html.twig', [
            'login_value' => $loginValue,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_login_values_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LoginValues $loginValue, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LoginValuesType::class, $loginValue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_login_values_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('login_values/edit.html.twig', [
            'login_value' => $loginValue,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/login', name: 'app_login_values_login', methods: ['GET', 'POST'])]
    public function login(LoginValues $loginValue): Response
    {
        $link="";
        $loginProvider=$loginValue->getLoginProvider();
        $authPath=$loginProvider->getAuthPath();
        $loginKey=$loginProvider->getLoginKey();
        $passwordKey=$loginProvider->getPasswordKey();
        $valueLogin=$loginValue->getLoginValue();
        $valuePassword=$loginValue->getPasswordValue();
        $link=$authPath.'?'.$loginKey.'='.$valueLogin.'&'.$passwordKey.'='.$valuePassword.'&'.$loginProvider->getCustomParams();
        dd($link);

        return $link;
    }

    #[Route('/{id}/delete', name: 'app_login_values_delete', methods: ['POST'])]
    public function delete(Request $request, LoginValues $loginValue, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$loginValue->getId(), $request->request->get('_token'))) {
            $entityManager->remove($loginValue);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_login_values_index', [], Response::HTTP_SEE_OTHER);
    }
}
