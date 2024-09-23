<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\AdmissionExaminationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdmissionExaminationRepository::class)]
class AdmissionExamination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'admissionExaminations')]
    private ?Faculty $Faculty = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\ManyToOne(inversedBy: 'admissionExaminations')]
    private ?AdmissionExaminationSubjects $ExaminationSubject = null;

    #[ORM\OneToMany(mappedBy: 'AdmissionExamination', targetEntity: AdmissionExaminationResult::class)]
    private Collection $admissionExaminationResults;

    #[ORM\ManyToOne(inversedBy: 'admissionExaminations')]
    private ?AdmissionPlan $AdmissionPlanPosition = null;

    #[ORM\Column(nullable: true)]
    private ?float $PassScore = null;

    public function __construct()
    {
        $this->admissionExaminationResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFaculty(): ?Faculty
    {
        return $this->Faculty;
    }

    public function setFaculty(?Faculty $Faculty): static
    {
        $this->Faculty = $Faculty;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getExaminationSubject(): ?AdmissionExaminationSubjects
    {
        return $this->ExaminationSubject;
    }

    public function setExaminationSubject(?AdmissionExaminationSubjects $ExaminationSubject): static
    {
        $this->ExaminationSubject = $ExaminationSubject;

        return $this;
    }
    public function __toString(): string
    {
     return $this->getDate()->format('d-m-Y').' '.$this->getFaculty().' - '.$this->getExaminationSubject();
    }

    /**
     * @return Collection<int, AdmissionExaminationResult>
     */
    public function getAdmissionExaminationResults(): Collection
    {
        return $this->admissionExaminationResults;
    }

    public function addAdmissionExaminationResult(AdmissionExaminationResult $admissionExaminationResult): static
    {
        if (!$this->admissionExaminationResults->contains($admissionExaminationResult)) {
            $this->admissionExaminationResults->add($admissionExaminationResult);
            $admissionExaminationResult->setAdmissionExamination($this);
        }

        return $this;
    }

    public function removeAdmissionExaminationResult(AdmissionExaminationResult $admissionExaminationResult): static
    {
        if ($this->admissionExaminationResults->removeElement($admissionExaminationResult)) {
            // set the owning side to null (unless already changed)
            if ($admissionExaminationResult->getAdmissionExamination() === $this) {
                $admissionExaminationResult->setAdmissionExamination(null);
            }
        }

        return $this;
    }

    public function getAdmissionPlanPosition(): ?AdmissionPlan
    {
        return $this->AdmissionPlanPosition;
    }

    public function setAdmissionPlanPosition(?AdmissionPlan $AdmissionPlanPosition): static
    {
        $this->AdmissionPlanPosition = $AdmissionPlanPosition;

        return $this;
    }

    public function getPassScore(): ?float
    {
        return $this->PassScore;
    }

    public function setPassScore(?float $PassScore): static
    {
        $this->PassScore = $PassScore;

        return $this;
    }
}
