<?php

namespace App\MainApp\Service\Admission;


use App\mod_mosregvis\Service\PetitionLoadService;

class PetitionAsyncService
{
    private array $message;


    public function __construct(
        private PetitionLoadService $petitionLoadService
    )
    {
    }

}