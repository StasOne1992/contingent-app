<?php

namespace App\mod_mosregvis\Controller;

use App\mod_mosregvis\Repository\modMosregVis_CollegeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/mod_mosregvis/college')]
#[IsGranted("ROLE_USER")]
class CollegeController extends AbstractController
{
    #[Route('/index', name: 'mod_mosregvis_college_index', methods: ['GET'])]
    public function index(modMosregVis_CollegeRepository $college_repository): Response
    {
        return $this->render('@mod_mosregvis/modMosregVis_College/index.html.twig',
            [
                'college_list' => $college_repository->findAll()
            ]
        );
    }
}