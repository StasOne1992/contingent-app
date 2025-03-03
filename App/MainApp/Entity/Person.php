<?php

namespace App\MainApp\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\MainApp\Repository\PersonRepository;
use App\mod_admission\Entity\AbiturientPetition;
use App\mod_education\Entity\Student;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Npub\Gos\Snils;

#[ORM\Entity(repositoryClass: PersonRepository::class)]
#[ApiResource]
class Person
{

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
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
    #[ORM\ManyToOne(inversedBy: 'Person')]
    private ?Gender $Gender = null;

    /**
     * @ORM\Column(type="snils", nullable=true, options={"unsigned": true, "comment": "СНИЛС"})
     *
     * @var Snils СНИЛС
     */
    #[ORM\Column(type: 'snils', nullable: true, options: ['unsigned' => true, 'comment' => 'СНИЛС'])]
    protected Snils|null $snils = null;

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

    #[ORM\OneToMany(mappedBy:'PersonDocument', targetEntity: PersonDocument::class)]
    private Collection $personDocument;


    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->staff = new ArrayCollection();
        $this->AbiturientPetition = new ArrayCollection();
        $this->personDocument = new ArrayCollection();
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


    /**
     * СНИЛС
     */
    public function getSnils(): Snils|null
    {
        return $this->snils;
    }

    /**
     * СНИЛС задан?
     */
    public function hasSnils(): bool
    {
        return (bool)$this->snils;
    }

    /**
     * Задать СНИЛС
     *
     * @param Snils|string|int|null $snils СНИЛС
     *
     * @throws ValueError
     */
    public function setSnils(Snils|string|int|null $snils): static
    {
        if (is_string($snils) || is_int($snils)) {
            if ($snils === '') {
                $this->snils = null;

                return $this;
            }

            $snils = Snils::createFromFormat($snils);
            if (!$snils) {
                throw new ValueError('Некорректный СНИЛС');
            }
        }

        if (!($this->snils instanceof Snils && $this->snils->isEqual($snils))) {
            // Заменяем значение только если оно изменилось
            $this->snils = $snils;
        }

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

    /**
     * @return Collection<int, PersonDocument>
     */
    public function getPersonDocument(): Collection
    {
        return $this->personDocument;
    }

    public function addPersonDocument(PersonDocument $personDocument): static
    {
        if (!$this->$personDocument->contains($personDocument)) {
            $this->$personDocument->add($personDocument);
            $personDocument->setPerson($this);
        }

        return $this;
    }

    public function removePersonDocument(PersonDocument $personDocument): static
    {
        if ($this->PersonDocument->removeElement($personDocument)) {
            // set the owning side to null (unless already changed)
            if ($personDocument->getPerson() === $this) {
                $personDocument->setPerson(null);
            }
        }
        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->Gender;
    }

    public function setGender(?Gender $Gender): void
    {
        $this->Gender = $Gender;
    }


}
