<?php

namespace App\mod_admission\Entity;

use Doctrine\ORM\Mapping as ORM;
use HeyMoon\DoctrinePostgresEnum\Attribute\EnumType;
use Symfony\Contracts\Translation\{TranslatableInterface, TranslatorInterface};

#[EnumType('admission_status')]
enum AdmissionStatus: string
{
    case draft = "DRAFT";
    case planning = "PLANNING";
    case reception = "RECEPTION";
    case open = "OPEN";
    case close = "CLOSE";

}
