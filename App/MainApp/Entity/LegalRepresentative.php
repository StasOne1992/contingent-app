<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\LegalRepresentativeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegalRepresentativeRepository::class)]
class LegalRepresentative
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MiddleName = null;

    #[ORM\Column(nullable: true)]
    private ?string $Phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Comment = null;

    #[ORM\ManyToOne(inversedBy: 'legalRepresentatives')]
    private ?LegalRepresentativeTypeList $RepresentativesType = null;

    #[ORM\ManyToOne(inversedBy: 'legalRepresentatives')]
    private ?Student $StudentID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->MiddleName;
    }

    public function setMiddleName(?string $MiddleName): self
    {
        $this->MiddleName = $MiddleName;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->Phone;
    }

    public function setPhone(?int $Phone): self
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(?string $Comment): self
    {
        $this->Comment = $Comment;

        return $this;
    }

    public function getRepresentativesType(): ?LegalRepresentativeTypeList
    {
        return $this->RepresentativesType;
    }

    public function setRepresentativesType(?LegalRepresentativeTypeList $RepresentativesType): self
    {
        $this->RepresentativesType = $RepresentativesType;

        return $this;
    }

    public function getStudentID(): ?Student
    {
        return $this->StudentID;
    }

    public function setStudentID(?Student $StudentID): self
    {
        $this->StudentID = $StudentID;

        return $this;
    }
}
