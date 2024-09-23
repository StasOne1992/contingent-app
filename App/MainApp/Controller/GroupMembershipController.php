<?php

namespace App\MainApp\Controller;

use App\MainApp\Entity\GroupMembership;
use App\MainApp\Form\GroupMembershipType;
use App\MainApp\Repository\GroupMembershipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/group/membership')]
class GroupMembershipController extends AbstractController
{
    #[Route('/', name: 'app_group_membership_index', methods: ['GET'])]
    public function index(GroupMembershipRepository $groupMembershipRepository): Response
    {
        return $this->render('group_membership/index.html.twig', [
            'group_memberships' => $groupMembershipRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_group_membership_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $groupMembership = new GroupMembership();
        $form = $this->createForm(GroupMembershipType::class, $groupMembership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($groupMembership);
            $entityManager->flush();

            return $this->redirectToRoute('app_group_membership_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('group_membership/new.html.twig', [
            'group_membership' => $groupMembership,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_group_membership_show', methods: ['GET'])]
    public function show(GroupMembership $groupMembership): Response
    {
        return $this->render('group_membership/show.html.twig', [
            'group_membership' => $groupMembership,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_group_membership_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, GroupMembership $groupMembership, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GroupMembershipType::class, $groupMembership);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_group_membership_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('group_membership/edit.html.twig', [
            'group_membership' => $groupMembership,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_group_membership_delete', methods: ['POST'])]
    public function delete(Request $request, GroupMembership $groupMembership, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$groupMembership->getId(), $request->request->get('_token'))) {
            $entityManager->remove($groupMembership);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_group_membership_index', [], Response::HTTP_SEE_OTHER);
    }
}
