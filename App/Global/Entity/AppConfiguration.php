<?php

namespace App\Global\Entity;

use App\Global\Repository\AppConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppConfigurationRepository::class)]
class AppConfiguration
{

    /***
     * Указывает на выполнение инициализации системы
     */

    #[ORM\Column(type: 'boolean')]
    private bool $initialComplete = false;
    #[ORM\Column(type: 'string')]
    private string $appLanguage = "RU-ru";

    public static function getAppLanguage(): string
    {
        return self::$appLanguage;
    }

    public static function setAppLanguage(string $appLanguage): void
    {
        self::$appLanguage = $appLanguage;
    }

    public function isInitialComplete(): bool
    {
        return $this->initialComplete;
    }

    public function setInitialComplete(bool $initialComplete): void
    {
        $this->initialComplete = $initialComplete;
    }
}