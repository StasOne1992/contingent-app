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

        $request = Request::create(
            '/mod_education/messenger/add_task',
            'POST',
            content: ['data' => $command]
        );
        $request->headers->add(["Content-Type" => "application/ld+json"]);
        $resonse = $request;
        dd($request);
    }
}