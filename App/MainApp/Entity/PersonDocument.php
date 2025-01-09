<?php

namespace App\MainApp\Entity;


use App\MainApp\Repository\PersonDocumentRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonDocumentRepository::class)]
class PersonDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private int $id;
    #[ORM\ManyToOne(inversedBy: 'PersonDocumentCategory')]
    private ?PersonDocumentCategory $documentCategory = null;
    #[ORM\Column(nullable: true)]
    private ?string $name;
    #[ORM\ManyToOne(inversedBy: 'Person')]
    private ?Person $person;
    #[ORM\Column(nullable: true)]
    private ?string $series;
    #[ORM\Column(nullable: true)]
    private ?string $number;
    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $issueDate = null;
    #[ORM\Column(nullable: true)]
    private ?string $issueOrgan;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note;
    #[ORM\Column(nullable: true)]
    private ?bool $actived = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getSeries(): ?string
    {
        return $this->series;
    }

    public function setSeries(?string $series): void
    {
        $this->series = $series;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    public function getIssueOrgan(): ?string
    {
        return $this->issueOrgan;
    }

    public function setIssueOrgan(?string $issueOrgan): void
    {
        $this->issueOrgan = $issueOrgan;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    public function getIssueDate(): ?DateTimeInterface
    {
        return $this->issueDate;
    }

    public function setIssueDate(?DateTimeInterface $issueDate): void
    {
        $this->issueDate = $issueDate;
    }

    public function getDocumentCategory(): ?PersonDocumentCategory
    {
        return $this->documentCategory;
    }

    public function setDocumentCategory(?PersonDocumentCategory $documentCategory): void
    {
        $this->documentCategory = $documentCategory;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): void
    {
        $this->person = $person;
    }

    public function isActived(): bool
    {
        return $this->actived;
    }

    public function setActived(bool $actived): void
    {
        $this->actived = $actived;
    }

}