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

    public function getAppLanguage(): string
    {
        return $this->appLanguage;
    }

    public function setAppLanguage(string $appLanguage): void
    {
        $this->appLanguage = $appLanguage;
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