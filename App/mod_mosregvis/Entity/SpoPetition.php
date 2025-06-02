<?php

namespace App\mod_mosregvis\Entity;

use App\MainApp\Entity\Person;
use App\mod_mosregvis\Repository\SpoPetitionRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: SpoPetitionRepository::class)]
class SpoPetition
{
    #[ORM\Id, ORM\GeneratedValue(strategy: 'SEQUENCE'), ORM\Column]
    private int|null $id = null;
    #[ORM\Column]
    private string $guid = "";
    #[ORM\Column]
    private float $number = 0;
    #[ORM\ManyToOne(targetEntity: Person::class, inversedBy: "spoPetition")]
    private ?Person $person;
    #[ORM\Column(type: 'json')]
    private string $petitionContent = "";

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): void
    {
        $this->person = $person;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getGuid(): string
    {
        return $this->guid;
    }

    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    public function getNumber(): float
    {
        return $this->number;
    }

    public function setNumber(float $number): void
    {
        $this->number = $number;
    }

    public function getPetitionContent(): string
    {
        return $this->petitionContent;
    }

    public function setPetitionContent(string $petitionContent): void
    {
        $this->petitionContent = $petitionContent;
    }

}