<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\AccessSystemControlRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessSystemControlRepository::class)]
class AccessSystemControl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'accessSystemControls')]
    private ?Student $Student = null;

    #[ORM\Column]
    private ?int $AccessCardSeries = null;

    #[ORM\Column]
    private ?int $AccesCardNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $IssueDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsLocked = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $LockDate = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAccessCardSeries(): ?int
    {
        return $this->AccessCardSeries;
    }

    public function setAccessCardSeries(int $AccessCardSeries): static
    {
        $this->AccessCardSeries = $AccessCardSeries;

        return $this;
    }

    public function getAccesCardNumber(): ?int
    {
        return $this->AccesCardNumber;
    }

    public function setAccesCardNumber(int $AccesCardNumber): static
    {
        $this->AccesCardNumber = $AccesCardNumber;

        return $this;
    }

    public function getIssueDate(): ?\DateTimeInterface
    {
        return $this->IssueDate;
    }

    public function setIssueDate(\DateTimeInterface $IssueDate): static
    {
        $this->IssueDate = $IssueDate;

        return $this;
    }

    public function isIsLocked(): ?bool
    {
        return $this->IsLocked;
    }

    public function setIsLocked(?bool $IsLocked): static
    {
        $this->IsLocked = $IsLocked;

        return $this;
    }

    public function getLockDate(): ?\DateTimeInterface
    {
        return $this->LockDate;
    }

    public function setLockDate(?\DateTimeInterface $LockDate): static
    {
        $this->LockDate = $LockDate;

        return $this;
    }

    public function __toString(): string
    {
     return $this->getAccessCardSeries().'.'.$this->getAccesCardNumber();
    }
}
