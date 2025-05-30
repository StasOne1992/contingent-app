<?php

namespace App\templates\components\StudentGroups;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class GroupListElement
{
    public string $type = 'success';
    public string $message;
}