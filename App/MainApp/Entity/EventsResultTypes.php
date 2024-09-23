<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\EventsResultTypesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsResultTypesRepository::class)]
class EventsResultTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column]
    private ?bool $IsWinner = null;

    #[ORM\Column]
    private ?bool $IsAwarded = null;

    #[ORM\Column]
    private ?bool $IsParticipant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function isIsWinner(): ?bool
    {
        return $this->IsWinner;
    }

    public function setIsWinner(bool $IsWinner): static
    {
        $this->IsWinner = $IsWinner;

        return $this;
    }

    public function isIsAwarded(): ?bool
    {
        return $this->IsAwarded;
    }

    public function setIsAwarded(bool $IsAwarded): static
    {
        $this->IsAwarded = $IsAwarded;

        return $this;
    }

    public function isIsParticipant(): ?bool
    {
        return $this->IsParticipant;
    }

    public function setIsParticipant(bool $IsParticipant): static
    {
        $this->IsParticipant = $IsParticipant;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }
}
