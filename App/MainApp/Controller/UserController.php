<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\User;
use App\MainApp\Form\UserType;
use App\MainApp\Repository\UserRepository;
use App\MainApp\Service\Messenger\BackgroudMessage;
use App\MainApp\Service\User\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @method getDoctrine()
 */
#[Route('/user')]
class UserController extends AbstractController
{

    #[IsGranted("ROLE_STAFF_STUDENT_R")]
    public function __construct(
        private BackgroudMessage $message,
    )
    {
    }


    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_R")]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_C")]
    public function new(Request $request, UserRepository $userRepository,UserService $userService): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userService->hashPassword($user,$user->getPassword()));
            $userRepository->save($user, true);
            $this->message->push('toast-notify', 'success', ' fa fa-check me-1 ', 'Пользователь создан!', "Пользователь ".$user);
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }


    #[Route('/{id}/show', name: 'app_user_show', methods: ['GET'])]
    #[IsGranted("ROLE_STAFF_STUDENT_R")]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_U")]
    public function edit(Request $request, User $user, UserRepository $userRepository,UserService $userService): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getPassword()!=$userService->hashPassword($user,$user->getPassword()))
            {
                $user->setPassword($userService->hashPassword($user,$user->getPassword()));
            }
            $userRepository->save($user, true);
            $this->message->push('toast-notify', 'success', ' fa fa-check me-1 ', 'Пользователь изменён!', "Пользователь ".$user->getUserIdentifier());
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/delete', name: 'app_user_delete', methods: ['POST'])]
    #[IsGranted("ROLE_STAFF_STUDENT_D")]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }
        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
