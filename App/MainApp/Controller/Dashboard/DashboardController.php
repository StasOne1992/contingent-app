<?php

namespace App\MainApp\Controller\Dashboard;


use App\MainApp\Repository\StudentGroupsRepository;
use App\MainApp\Repository\UserRepository;
use App\MainApp\Service\Messenger\BackgroudMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard')]
#[IsGranted("ROLE_USER")]
class DashboardController extends AbstractController
{
    public function __construct()
    {

    }

    #[Route('/', name: 'app_dashboard_index', methods: ['GET'])]
    public function index(StudentGroupsRepository $StudentGroupsRepository,UserRepository $UserRepository,BackgroudMessage $backgroudMessage): Response
    {
        $this->currentUser=$UserRepository->find($this->getUser());
        $this->groupLeaderId=$this->currentUser->getStaff()->getId();
        $this->groups=$StudentGroupsRepository->findAll();
        //$backgroudMessage->push('toast-notify', 'success', ' fa fa-check me-1 ', 'БЛОКИРОВКА. Заявление не доступно для изменения', "2123124124");
        return $this->render('dashboard/index.html.twig',
            [
                'groups'=>$this->groups
            ]);
    }

}