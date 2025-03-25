<?php

namespace App\mod_education\Messenger\Controller;

use App\mod_education\Messenger\Message\GroupMembership\AddGroupMembershipMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/mod_education/messenger')]
class ModEducationMessageController extends AbstractController
{
    #[Route('/add_to_contingent_document', name: 'app_mod_education_messenger_index', methods: ['GET', 'POST'])]
    public function addTask(Request $request, MessageBusInterface $bus): Response
    {
        $task = json_decode($request->getContent());
        dd($task);
        foreach ($task as $item) {
            $message = new AddGroupMembershipMessage(json_encode($item));
            try {
                $dispatch = $bus->dispatch($message);
            } catch (ExceptionInterface $e) {
            }
            dd();
        }


        $response->setContent(json_encode($data));
        return $response;
        //$this->bus->dispatch(new AddTaskMessage());
    }
}