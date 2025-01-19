<?php

namespace App\mod_education\Entity;

use App\mod_education\Repository\EducationPlanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducationPlanRepository::class)]
class EducationPlan
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'educationPlans')]
    private ?Faculty $Faculty = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateEnd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    #[ORM\Column(length: 255,nullable: true )]
    private ?string $Qualification = null;

    #[ORM\ManyToOne(inversedBy: 'educationPlans')]
    private ?EducationForm $EducationForm = null;

    #[ORM\ManyToOne(inversedBy: 'educationPlans')]
    private ?EducationType $BaseEducationType = null;

    #[ORM\OneToMany(mappedBy: 'EducationPlan', targetEntity: StudentGroup::class)]
    private Collection $studentGroup;

    #[ORM\OneToMany(mappedBy: 'EducationPlan', targetEntity: EducationSemester::class)]
    private Collection $educationSemesters;

    public function __construct()
    {
        $this->studentGroup = new ArrayCollection();
        $this->educationSemesters = new ArrayCollection();
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

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->DateStart;
    }

    public function setDateStart(\DateTimeInterface $DateStart): static
    {
        $this->DateStart = $DateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->DateEnd;
    }

    public function setDateEnd(?\DateTimeInterface $DateEnd): static
    {
        $this->DateEnd = $DateEnd;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->Qualification;
    }

    public function setQualification(string $Qualification): static
    {
        $this->Qualification = $Qualification;

        return $this;
    }

    public function getEducationForm(): ?EducationForm
    {
        return $this->EducationForm;
    }

    public function setEducationForm(?EducationForm $EducationForm): static
    {
        $this->EducationForm = $EducationForm;

        return $this;
    }

    public function getBaseEducationType(): ?EducationType
    {
        return $this->BaseEducationType;
    }

    public function setBaseEducationType(?EducationType $BaseEducationType): static
    {
        $this->BaseEducationType = $BaseEducationType;

        return $this;
    }

    /**
     * @return Collection<int, StudentGroup>
     */
    public function getStudentGroups(): Collection
    {
        return $this->studentGroup;
    }

    public function addStudentGroup(StudentGroup $studentGroup): static
    {
        if (!$this->studentGroup->contains($studentGroup)) {
            $this->studentGroup->add($studentGroup);
            $studentGroup->setEducationPlan($this);
        }

        return $this;
    }

    public function removeStudentGroup(StudentGroup $studentGroup): static
    {
        if ($this->studentGroup->removeElement($studentGroup)) {
            // set the owning side to null (unless already changed)
            if ($studentGroup->getEducationPlan() === $this) {
                $studentGroup->setEducationPlan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EducationSemester>
     */
    public function getEducationSemesters(): Collection
    {
        return $this->educationSemesters;
    }

    public function addEducationSemester(EducationSemester $educationSemester): static
    {
        if (!$this->educationSemesters->contains($educationSemester)) {
            $this->educationSemesters->add($educationSemester);
            $educationSemester->setEducationPlan($this);
        }

        return $this;
    }

    public function removeEducationSemester(EducationSemester $educationSemester): static
    {
        if ($this->educationSemesters->removeElement($educationSemester)) {
            // set the owning side to null (unless already changed)
            if ($educationSemester->getEducationPlan() === $this) {
                $educationSemester->setEducationPlan(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
     return $this->getTitle();
    }
}
