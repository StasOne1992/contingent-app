<?php

namespace App\mod_education\Messenger\MessageHandler\GroupMembership;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;

class AddTaskHandler
{
    public function __invoke(AddTask $command): void
    {
        dd($command);
    }
}