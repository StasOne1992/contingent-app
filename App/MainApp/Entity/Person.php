<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\PersonRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
class Person
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MiddleName = null;

    #[ORM\Column(length: 12, nullable: true)]
    private ?string $INN = null;

    #[ORM\Column(length: 14)]
    private ?string $SNILS = null;

    #[ORM\Column(length: 6, nullable: true)]
    private ?string $MedicalSeries = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $MedicalNumber = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $BirthPlace = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $MedicalDateIssue = null;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: student::class)]
    private Collection $student;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: staff::class)]
    private Collection $staff;

    #[ORM\OneToMany(mappedBy: 'person', targetEntity: AbiturientPetition::class)]
    private Collection $AbiturientPetition;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $birthDate = null;

    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->staff = new ArrayCollection();
        $this->AbiturientPetition = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->MiddleName;
    }

    public function setMiddleName(?string $MiddleName): static
    {
        $this->MiddleName = $MiddleName;

        return $this;
    }

    public function getINN(): ?string
    {
        return $this->INN;
    }

    public function setINN(?string $INN): static
    {
        $this->INN = $INN;

        return $this;
    }

    public function getSNILS(): ?string
    {
        return $this->SNILS;
    }

    public function setSNILS(string $SNILS): static
    {
        $this->SNILS = $SNILS;

        return $this;
    }

    public function getMedicalSeries(): ?string
    {
        return $this->MedicalSeries;
    }

    public function setMedicalSeries(?string $MedicalSeries): static
    {
        $this->MedicalSeries = $MedicalSeries;

        return $this;
    }

    public function getMedicalNumber(): ?string
    {
        return $this->MedicalNumber;
    }

    public function setMedicalNumber(?string $MedicalNumber): static
    {
        $this->MedicalNumber = $MedicalNumber;

        return $this;
    }

    public function getBirthPlace(): ?string
    {
        return $this->BirthPlace;
    }

    public function setBirthPlace(?string $BirthPlace): static
    {
        $this->BirthPlace = $BirthPlace;

        return $this;
    }

    public function getMedicalDateIssue(): ?DateTimeInterface
    {
        return $this->MedicalDateIssue;
    }

    public function setMedicalDateIssue(?DateTimeInterface $MedicalDateIssue): static
    {
        $this->MedicalDateIssue = $MedicalDateIssue;

        return $this;
    }

    /**
     * @return Collection<int, student>
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(student $student): static
    {
        if (!$this->student->contains($student)) {
            $this->student->add($student);
            $student->setPerson($this);
        }

        return $this;
    }

    public function removeStudent(student $student): static
    {
        if ($this->student->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getPerson() === $this) {
                $student->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, staff>
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(staff $staff): static
    {
        if (!$this->staff->contains($staff)) {
            $this->staff->add($staff);
            $staff->setPerson($this);
        }

        return $this;
    }

    public function removeStaff(staff $staff): static
    {
        if ($this->staff->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getPerson() === $this) {
                $staff->setPerson(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AbiturientPetition>
     */
    public function getAbiturientPetition(): Collection
    {
        return $this->AbiturientPetition;
    }

    public function addAbiturientPetition(AbiturientPetition $abiturientPetition): static
    {
        if (!$this->AbiturientPetition->contains($abiturientPetition)) {
            $this->AbiturientPetition->add($abiturientPetition);
            $abiturientPetition->setPerson($this);
        }

        return $this;
    }

    public function removeAbiturientPetition(AbiturientPetition $abiturientPetition): static
    {
        if ($this->AbiturientPetition->removeElement($abiturientPetition)) {
            // set the owning side to null (unless already changed)
            if ($abiturientPetition->getPerson() === $this) {
                $abiturientPetition->setPerson(null);
            }
        }

        return $this;
    }

    public function getBirthDate(): ?DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }
}
