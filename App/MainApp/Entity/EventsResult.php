<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\EventsResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsResultRepository::class)]
class EventsResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'eventsResults')]
    private ?EventsList $Event = null;

    #[ORM\ManyToOne(inversedBy: 'eventsResults')]
    private ?Student $Student = null;

    #[ORM\ManyToOne(inversedBy: 'eventsResults')]
    private ?EventsResultTypes $ResultType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?EventsList
    {
        return $this->Event;
    }

    public function setEvent(?EventsList $Event): static
    {
        $this->Event = $Event;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->Student;
    }

    public function setStudent(?Student $Student): static
    {
        $this->Student = $Student;

        return $this;
    }

    public function getResultType(): ?EventsResultTypes
    {
        return $this->ResultType;
    }

    public function setResultType(?EventsResultTypes $ResultType): static
    {
        $this->ResultType = $ResultType;

        return $this;
    }
}
