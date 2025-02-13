<?php

namespace App\mod_education\Messenger\MessageHandler\GroupMembership;

use App\mod_education\Messenger\Message\GroupMembership\AddGroupMembershipMessage;
use http\Client\Response;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
class AddGroupMembershipMessageHandler
{
    public function __invoke(AddGroupMembershipMessage $command,): void
    {
        $this->addGroupMemberShip($command->getContent());
        dd("some");
    }

    private function addGroupMemberShip($data)
    {
        dd(json_decode($data));
    }

}