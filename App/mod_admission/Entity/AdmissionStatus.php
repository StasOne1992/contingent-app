<?php
namespace App\mod_admission\Entity;

use HeyMoon\DoctrinePostgresEnum\Attribute\EnumType;



#[EnumType('admission_status')]
enum AdmissionStatus: string
{
    case draft = "DRAFT";
    case planning = "PLANNING";
    case reception = "RECEPTION";
    case open = "OPEN";
    case close = "CLOSE";

}
