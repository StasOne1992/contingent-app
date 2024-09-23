<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\AdmissionPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdmissionPlanRepository::class)]
class AdmissionPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'admissionPlans')]
    private ?Admission $admission = null;

    #[ORM\Column(nullable: true)]
    private ?int $TargetCount = null;

    #[ORM\ManyToOne(inversedBy: 'admissionPlans')]
    private ?Faculty $faculty = null;

    #[ORM\Column(options:['default'=>false], nullable: true)]
    private ?bool $HaveAdmissionExamination = null;

    #[ORM\OneToMany(mappedBy: 'AdmissionPlanPosition', targetEntity: AdmissionExamination::class)]
    private Collection $admissionExaminations;

    public function __construct()
    {
        $this->admissionExaminations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdmission(): ?Admission
    {
        return $this->admission;
    }

    public function setAdmission(?Admission $admission): static
    {
        $this->admission = $admission;

        return $this;
    }

    public function getTargetCount(): ?int
    {
        return $this->TargetCount;
    }

    public function setTargetCount(?int $TargetCount): static
    {
        $this->TargetCount = $TargetCount;

        return $this;
    }


    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(?Faculty $faculty): static
    {
        $this->faculty = $faculty;

        return $this;
    }

    public function isHaveAdmissionExamination(): ?bool
    {
        return $this->HaveAdmissionExamination;
    }

    public function setHaveAdmissionExamination(bool $HaveAdmissionExamination): static
    {
        $this->HaveAdmissionExamination = $HaveAdmissionExamination;

        return $this;
    }

    public function __toString(): string
    {
     return $this->getFaculty().' '.$this->getAdmission();
    }

    /**
     * @return Collection<int, AdmissionExamination>
     */
    public function getAdmissionExaminations(): Collection
    {
        return $this->admissionExaminations;
    }

    public function addAdmissionExamination(AdmissionExamination $admissionExamination): static
    {
        if (!$this->admissionExaminations->contains($admissionExamination)) {
            $this->admissionExaminations->add($admissionExamination);
            $admissionExamination->setAdmissionPlanPosition($this);
        }

        return $this;
    }

    public function removeAdmissionExamination(AdmissionExamination $admissionExamination): static
    {
        if ($this->admissionExaminations->removeElement($admissionExamination)) {
            // set the owning side to null (unless already changed)
            if ($admissionExamination->getAdmissionPlanPosition() === $this) {
                $admissionExamination->setAdmissionPlanPosition(null);
            }
        }

        return $this;
    }
}
