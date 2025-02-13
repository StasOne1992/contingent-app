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

    #[Route('/add_task', name: 'app_mod_education_messenger_index', methods: ['GET', 'POST'])]
    public function addTask(Request $request, MessageBusInterface $bus): Response
    {
        $data = $request->request->all();
        $data =
            '{
        "0":{"@id":"/api/students/698","@type":"Student","id":698,"FirstName":"Ящук","LastName":"Альбина","MiddleName":"Ильишна","DocumentSnils":"334-932-984 01","person":"/api/people/713"},
        "1":{"@id":"/api/students/734","@type":"Student","id":734,"FirstName":"Ящина","LastName":"Ярослава","MiddleName":"Леонтьевна","DocumentSnils":"665-383-857 46","person":"/api/people/749"}
        }';
        $task = json_decode($data);
        dump($task);
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