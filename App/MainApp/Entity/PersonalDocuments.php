<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\PersonalDocumentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PersonalDocumentsRepository::class)]
class PersonalDocuments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'personalDocuments')]
    private ?PersonalDocTypeList $DocumentType = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $DocumentSeries = null;

    #[ORM\ManyToOne(inversedBy: 'personalDocuments')]
    private ?Student $Student = null;

    #[ORM\Column(nullable: true)]
    private ?string $DocumentNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DocumentIssueDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $DocumentOfficialSeal = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Comment = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDocumentType(): ?PersonalDocTypeList
    {
        return $this->DocumentType;
    }

    public function setDocumentType(?PersonalDocTypeList $DocumentType): self
    {
        $this->DocumentType = $DocumentType;

        return $this;
    }

    public function getDocumentSeries(): ?string
    {
        return $this->DocumentSeries;
    }

    public function setDocumentSeries(?string $DocumentSeries): self
    {
        $this->DocumentSeries = $DocumentSeries;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->Student;
    }

    public function setStudent(?Student $Student): self
    {
        $this->Student = $Student;
        return $this;
    }
    public function getStudentById($StudentID,$studentRepository):Student
    {
        $student=$studentRepository->findOneById($StudentID);
        return($student);
    }

    public function getDocumentNumber(): ?int
    {
        return $this->DocumentNumber;
    }

    public function setDocumentNumber(?int $DocumentNumber): self
    {
        $this->DocumentNumber = $DocumentNumber;

        return $this;
    }

    public function getDocumentIssueDate(): ?\DateTimeInterface
    {
        return $this->DocumentIssueDate;
    }

    public function setDocumentIssueDate(?\DateTimeInterface $DocumentIssueDate): self
    {
        $this->DocumentIssueDate = $DocumentIssueDate;

        return $this;
    }

    public function getDocumentOfficialSeal(): ?string
    {
        return $this->DocumentOfficialSeal;
    }

    public function setDocumentOfficialSeal(?string $DocumentOfficialSeal): self
    {
        $this->DocumentOfficialSeal = $DocumentOfficialSeal;

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
    public function __toString()
    {
        return (string) $this->getDocumentType();
    }

}
