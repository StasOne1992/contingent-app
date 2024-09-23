<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\FacultyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacultyRepository::class)]
class Faculty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'Faculty', targetEntity: StudentGroups::class)]
    private Collection $studentGroups;

    #[ORM\ManyToOne(inversedBy: 'faculties')]
    private ?Specialization $Specialization = null;

    #[ORM\ManyToOne(inversedBy: 'faculties')]
    private ?EducationType $EducationType = null;

    #[ORM\ManyToOne(inversedBy: 'faculties')]
    private ?EducationForm $EducationForm = null;

    #[ORM\OneToMany(mappedBy: 'faculty', targetEntity: AdmissionPlan::class)]
    private Collection $admissionPlans;

    #[ORM\OneToMany(mappedBy: 'Faculty', targetEntity: AbiturientPetition::class)]
    private Collection $abiturientPetitions;

    #[ORM\ManyToOne(inversedBy: 'faculties')]
    private ?FinancialType $financialType = null;

    #[ORM\OneToMany(mappedBy: 'Faculty', targetEntity: EducationPlan::class)]
    private Collection $educationPlans;

    #[ORM\OneToMany(mappedBy: 'Faculty', targetEntity: AdmissionExamination::class)]
    private Collection $admissionExaminations;


    public function __construct()
    {
        $this->studentGroups = new ArrayCollection();
        $this->admissionPlans = new ArrayCollection();
        $this->abiturientPetitions = new ArrayCollection();
        $this->educationPlans = new ArrayCollection();
        $this->admissionExaminations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, StudentGroups>
     */
    public function getStudentGroups(): Collection
    {
        return $this->studentGroups;
    }

    public function addStudentGroup(StudentGroups $studentGroup): self
    {
        if (!$this->studentGroups->contains($studentGroup)) {
            $this->studentGroups->add($studentGroup);
            $studentGroup->setFaculty($this);
        }

        return $this;
    }

    public function removeStudentGroup(StudentGroups $studentGroup): self
    {
        if ($this->studentGroups->removeElement($studentGroup)) {
            // set the owning side to null (unless already changed)
            if ($studentGroup->getFaculty() === $this) {
                $studentGroup->setFaculty(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->Name . " (" . $this->getEducationForm()->getTitle() . " форма, " . $this->getFinancialType()->getTitle() . ", " . $this->getEducationType()->getTitle() . ")";
    }

    public function getSpecialization(): ?Specialization
    {
        return $this->Specialization;
    }

    public function setSpecialization(?Specialization $Specialization): self
    {
        $this->Specialization = $Specialization;

        return $this;
    }

    public function getEducationType(): ?EducationType
    {
        return $this->EducationType;
    }

    public function setEducationType(?EducationType $EducationType): self
    {
        $this->EducationType = $EducationType;

        return $this;
    }

    public function getEducationForm(): ?EducationForm
    {
        return $this->EducationForm;
    }

    public function setEducationForm(?EducationForm $EducationForm): self
    {
        $this->EducationForm = $EducationForm;

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
            $admissionPlan->setFaculty($this);
        }

        return $this;
    }

    public function removeAdmissionPlan(AdmissionPlan $admissionPlan): static
    {
        if ($this->admissionPlans->removeElement($admissionPlan)) {
            // set the owning side to null (unless already changed)
            if ($admissionPlan->getFaculty() === $this) {
                $admissionPlan->setFaculty(null);
            }
        }

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
            $abiturientPetition->setFaculty($this);
        }

        return $this;
    }

    public function removeAbiturientPetition(AbiturientPetition $abiturientPetition): static
    {
        if ($this->abiturientPetitions->removeElement($abiturientPetition)) {
            // set the owning side to null (unless already changed)
            if ($abiturientPetition->getFaculty() === $this) {
                $abiturientPetition->setFaculty(null);
            }
        }

        return $this;
    }

    public function getFinancialType(): ?FinancialType
    {
        return $this->financialType;
    }

    public function setFinancialType(?FinancialType $financialType): static
    {
        $this->financialType = $financialType;

        return $this;
    }

    /**
     * @return Collection<int, EducationPlan>
     */
    public function getEducationPlans(): Collection
    {
        return $this->educationPlans;
    }

    public function addEducationPlan(EducationPlan $educationPlan): static
    {
        if (!$this->educationPlans->contains($educationPlan)) {
            $this->educationPlans->add($educationPlan);
            $educationPlan->setFaculty($this);
        }

        return $this;
    }

    public function removeEducationPlan(EducationPlan $educationPlan): static
    {
        if ($this->educationPlans->removeElement($educationPlan)) {
            // set the owning side to null (unless already changed)
            if ($educationPlan->getFaculty() === $this) {
                $educationPlan->setFaculty(null);
            }
        }

        return $this;
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
            $admissionExamination->setFaculty($this);
        }

        return $this;
    }

    public function removeAdmissionExamination(AdmissionExamination $admissionExamination): static
    {
        if ($this->admissionExaminations->removeElement($admissionExamination)) {
            // set the owning side to null (unless already changed)
            if ($admissionExamination->getFaculty() === $this) {
                $admissionExamination->setFaculty(null);
            }
        }

        return $this;
    }


}
