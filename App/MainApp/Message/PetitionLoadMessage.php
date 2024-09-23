<?php

namespace App\MainApp\Message;

class PetitionLoadMessage
{
    private array $abiturientPetition;

    public function __construct(
        array $abiturientPetition,
    )

    {
        $this->abiturientPetition = $abiturientPetition;
    }

    public
    function getAbiturientPetition(): array
    {
        return $this->abiturientPetition;
    }
}