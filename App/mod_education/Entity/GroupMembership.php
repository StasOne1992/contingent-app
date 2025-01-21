<?php

namespace App\mod_education\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\mod_education\Repository\GroupMembershipRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupMembershipRepository::class)]
#[ApiResource]
class GroupMembership
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'groupMemberships')]
    private ?Student $Student = null;

    #[ORM\ManyToOne(inversedBy: 'groupMemberships')]
    private ?StudentGroup $StudentGroup = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateEnd = null;

    #[ORM\ManyToOne(targetEntity: ContingentDocument::class, inversedBy: 'groupMemberships')]
    private ?ContingentDocument $ContingentDocument = null;

    #[ORM\Column(nullable: true)]
    private ?bool $Active = null;


    public function __construct()
    {

    }

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

    public function getStudentGroup(): ?StudentGroup
    {
        return $this->StudentGroup;
    }

    public function setStudentGroup(?StudentGroup $StudentGroup): static
    {
        $this->StudentGroup = $StudentGroup;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->DateStart;
    }

    public function setDateStart(?\DateTimeInterface $DateStart): static
    {
        $this->DateStart = $DateStart;
        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->DateEnd;
    }

    public function setDateEnd(\DateTimeInterface $DateEnd): static
    {
        $this->DateEnd = $DateEnd;
        return $this;
    }

    public function getContingentDocument(): ?ContingentDocument
    {
        return $this->ContingentDocument;
    }

    public function setContingentDocument(?ContingentDocument $ContingentDocument): static
    {
        $this->ContingentDocument = $ContingentDocument;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->Active;
    }

    public function setActive(bool $Active): static
    {
        $this->Active = $Active;
        return $this;
    }
}