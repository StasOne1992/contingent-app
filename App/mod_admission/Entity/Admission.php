<?php

namespace App\mod_admission\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\MainApp\Entity\College;
use App\mod_admission\Repository\AdmissionRepository;
use App\mod_mosregvis\Entity\reference_SpoEducationYear;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdmissionRepository::class)]
#[ApiResource]
class Admission
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateEnd = null;

    #[ORM\OneToMany(targetEntity: AdmissionPlan::class, mappedBy: 'admission')]
    private Collection $admissionPlans;

    #[ORM\Column(type: 'enum', enumType: AdmissionStatus::class)]
    private AdmissionStatus|null $status = AdmissionStatus::draft;

    #[ORM\OneToMany(targetEntity: AbiturientPetition::class, mappedBy: 'admission')]
    private Collection $abiturientPetitions;

    #[ORM\ManyToOne(inversedBy: 'admissions')]
    private ?College $college = null;

    #[ORM\Column (nullable: true)]
    private ?bool $active = false;

    #[ORM\OneToOne(targetEntity: reference_SpoEducationYear::class)]
    private ?reference_SpoEducationYear $spoEducationYear;

    public function __construct()
    {
        $this->status = AdmissionStatus::draft;
        $this->admissionPlans = new ArrayCollection();
        $this->abiturientPetitions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * @return Collection<int, AdmissionPlan>
     */
    public function getAdmissionPlans(): Collection
    {
        return $this->admissionPlans;
    }

    public function addAdmissionPlan(AdmissionPlan $admissionPlan): static
    {
        if (!$this->admissionPlans->contains($admissionPlan)) {
            $this->admissionPlans->add($admissionPlan);
            $admissionPlan->setAdmission($this);
        }

        return $this;
    }

    public function removeAdmissionPlan(AdmissionPlan $admissionPlan): static
    {
        if ($this->admissionPlans->removeElement($admissionPlan)) {
            // set the owning side to null (unless already changed)
            if ($admissionPlan->getAdmission() === $this) {
                $admissionPlan->setAdmission(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getStatus(): AdmissionStatus
    {
        return $this->status;
    }

    public function setStatus(AdmissionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, AbiturientPetition>
     */
    public function getAbiturientPetitions(): Collection
    {
        return $this->abiturientPetitions;
    }

    public function addAbiturientPetition(AbiturientPetition $abiturientPetition): static
    {
        if (!$this->abiturientPetitions->contains($abiturientPetition)) {
            $this->abiturientPetitions->add($abiturientPetition);
            $abiturientPetition->setAdmission($this);
        }

        return $this;
    }

    public function removeAbiturientPetition(AbiturientPetition $abiturientPetition): static
    {
        if ($this->abiturientPetitions->removeElement($abiturientPetition)) {
            // set the owning side to null (unless already changed)
            if ($abiturientPetition->getAdmission() === $this) {
                $abiturientPetition->setAdmission(null);
            }
        }

        return $this;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): static
    {
        $this->college = $college;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getSpoEducationYear(): ?reference_SpoEducationYear
    {
        return $this->spoEducationYear;
    }

    public function setSpoEducationYear(?reference_SpoEducationYear $spoEducationYear): void
    {
        $this->spoEducationYear = $spoEducationYear;
    }
}
