<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\GenderRepository;
use App\mod_admission\Entity\AbiturientPetition;
use App\mod_education\Entity\Student;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'gender', targetEntity: Person::class)]
    private Collection $persons;

    #[ORM\OneToMany(mappedBy: 'gender', targetEntity: AbiturientPetition::class)]
    private Collection $abiturientPetitions;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $genderName = null;

    public function __construct()
    {
        $this->abiturientPetitions = new ArrayCollection();
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
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setGender($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getGender() === $this) {
                $student->setGender(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getName();
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
            $abiturientPetition->setGender($this);
        }

        return $this;
    }

    public function removeAbiturientPetition(AbiturientPetition $abiturientPetition): static
    {
        if ($this->abiturientPetitions->removeElement($abiturientPetition)) {
            // set the owning side to null (unless already changed)
            if ($abiturientPetition->getGender() === $this) {
                $abiturientPetition->setGender(null);
            }
        }

        return $this;
    }

    public function getGenderName(): ?string
    {
        return $this->genderName;
    }

    public function setGenderName(string $genderName): static
    {
        $this->genderName = $genderName;

        return $this;
    }

    public function getPersons(): Collection
    {
        return $this->persons;
    }

    public function setPersons(Collection $persons): void
    {
        $this->persons = $persons;
    }
}
