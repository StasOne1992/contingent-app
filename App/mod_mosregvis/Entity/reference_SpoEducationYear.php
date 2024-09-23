<?php

namespace App\mod_mosregvis\Entity;

use App\MainApp\Entity\Admission;
use App\mod_mosregvis\Repository\reference_SpoEducationYearRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: reference_SpoEducationYearRepository::class)]
class reference_SpoEducationYear
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $guid = null;
    #[ORM\Column]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: reference_eduYearStatus::class, inversedBy: 'reference_eduYearStatus')]
    private ?reference_eduYearStatus $yearStatus;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $orderId = null;

    #[ORM\OneToOne(targetEntity: Admission::class)]
    private $admisson;
    #[ORM\ManyToOne(targetEntity: MosregVISCollege::class, inversedBy: 'college')]
    private ?MosregVISCollege $college;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(?string $guid): void
    {
        $this->guid = $guid;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getCollege(): MosregVISCollege
    {
        return $this->college;
    }

    public function setCollege(MosregVISCollege $college): void
    {
        $this->college = $college;
    }


    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }


    public function setEndDate(?\DateTimeInterface $endDate): void
    {
        $this->endDate = $endDate;
    }

    public function getYearStatus(): ?reference_eduYearStatus
    {
        return $this->yearStatus;
    }

    public function setYearStatus(?reference_eduYearStatus $yearStatus): void
    {
        $this->yearStatus = $yearStatus;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): void
    {
        $this->orderId = $orderId;
    }

}