<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\EducationSemesterRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducationSemesterRepository::class)]
class EducationSemester
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\ManyToOne(inversedBy: 'educationSemesters')]
    private ?EducationYear $EducationYear = null;

    #[ORM\ManyToOne(inversedBy: 'educationSemesters')]
    private ?EducationPlan $EducationPlan = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getEducationYear(): ?EducationYear
    {
        return $this->EducationYear;
    }

    public function setEducationYear(?EducationYear $EducationYear): static
    {
        $this->EducationYear = $EducationYear;

        return $this;
    }

    public function getEducationPlan(): ?EducationPlan
    {
        return $this->EducationPlan;
    }

    public function setEducationPlan(?EducationPlan $EducationPlan): static
    {
        $this->EducationPlan = $EducationPlan;

        return $this;
    }
}
