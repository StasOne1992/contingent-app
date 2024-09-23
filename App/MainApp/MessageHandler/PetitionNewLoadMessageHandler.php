<?php

namespace App\MainApp\MessageHandler;


use App\MainApp\Message\PetitionNewLoadMessage;
use App\mod_mosregvis\Service\PetitionLoadService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Notifier\NotifierInterface;

#[AsMessageHandler]
class PetitionNewLoadMessageHandler
{
    private PetitionLoadService $petitionLoadService;
    private NotifierInterface $notifier;

    public function __construct(
        PetitionLoadService $petitionLoadService,
        NotifierInterface $notifier
    )
    {
        $this->notifier = $notifier;
        $this->petitionLoadService = $petitionLoadService;
    }

    public function __invoke(PetitionNewLoadMessage $message):void
    {
        $this->petitionLoadService->pubCreatePetition($message->getAbiturientPetition());
    }
}