<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\SystemServicesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SystemServicesRepository::class)]
class SystemServices
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $SystemName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getSystemName(): ?string
    {
        return $this->SystemName;
    }

    public function setSystemName(string $SystemName): static
    {
        $this->SystemName = $SystemName;

        return $this;
    }
}
