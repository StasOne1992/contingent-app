<?php

namespace App\mod_mosregvis\Entity;

use App\mod_mosregvis\Repository\reference_eduYearStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: reference_eduYearStatusRepository::class)]
class reference_eduYearStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?int $code = null;
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'reference_SpoEducationYear', targetEntity: reference_SpoEducationYear::class)]
    private Collection $spoEducationYear;

    public function __construct()
    {
        $this->spoEducationYear = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(?int $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getSpoEducationYear(): Collection
    {
        return $this->spoEducationYear;
    }


    public function addSpoEducationYear(reference_SpoEducationYear $year): self
    {
        if (!$this->spoEducationYear->contains($year)) {
            $this->spoEducationYear->add($year);
        }
        return $this;
    }


}