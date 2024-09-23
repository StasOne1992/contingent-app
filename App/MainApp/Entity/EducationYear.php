<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\EducationYearRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducationYearRepository::class)]
class EducationYear
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEnd = null;

    #[ORM\OneToMany(mappedBy: 'EducationYear', targetEntity: EducationSemester::class)]
    private Collection $educationSemesters;

    public function __construct()
    {
        $this->educationSemesters = new ArrayCollection();
    }

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

    public function setDateEnd(\DateTimeInterface $DateEnd): static
    {
        $this->DateEnd = $DateEnd;

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
            $educationSemester->setEducationYear($this);
        }

        return $this;
    }

    public function removeEducationSemester(EducationSemester $educationSemester): static
    {
        if ($this->educationSemesters->removeElement($educationSemester)) {
            // set the owning side to null (unless already changed)
            if ($educationSemester->getEducationYear() === $this) {
                $educationSemester->setEducationYear(null);
            }
        }

        return $this;
    }
}
