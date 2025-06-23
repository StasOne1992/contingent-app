<?php

namespace App\mod_education\Entity;

use App\MainApp\Entity\AccessSystemControl;
use App\MainApp\Entity\Gender;
use App\MainApp\Entity\LoginValues;
use App\MainApp\Entity\Person;
use App\MainApp\Entity\User;
use App\MainApp\Service\StudentService;
use App\mod_admission\Entity\AbiturientPetition;
use App\mod_education\Repository\StudentRepository;
use App\mod_events\Entity\EventsList;
use App\mod_events\Entity\EventsResult;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Npub\Gos\Snils;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Component\Serializer\Attribute\Groups;


#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'student:item']),
        new GetCollection(normalizationContext: ['groups' => 'student:list'])
    ],
    order: ['person.FirstName'],

    paginationEnabled: false,
)]
#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups(['student:list', 'student:item','contingent_document:item'])]
    private ?int $id = null;
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $NumberZachetka = null;
    #[ORM\Column(length: 10, nullable: true)]
    private ?string $NumberStudBilet = null;

    private ?DateTimeInterface $BirthDate = null;
    #[ORM\Column(length: 255, nullable: false)]
    private ?string $PhoneNumber = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;
    #[Groups(
        [
        'student:list',
        'student:item',
        'contingent_document:item'
        ]
    )]
    private ?string $FirstName = null;
    #[Groups(
        [
            'student:list',
            'student:item',
            'contingent_document:item'
        ]
    )]
    private ?string $LastName = null;
    #[Groups(
        [
            'student:list',
            'student:item',
            'contingent_document:item'
        ]
    )]
    private ?string $MiddleName = null;
    #[Groups(
        [
            'student:list',
            'student:item',
            'contingent_document:item'
        ]
    )]
    private ?Snils $DocumentSnils = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DocumentMedicalID = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AddressFact = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AddressMain = null;

    #[ORM\ManyToOne(targetEntity: FamilyTypeList::class, inversedBy: 'students')]
    private ?FamilyTypeList $familyTypeID = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?HealthGroup $healthGroupID = null;

    #[ORM\OneToMany(mappedBy: 'StudentID', targetEntity: LegalRepresentative::class)]
    private Collection $legalRepresentatives;

    #[ORM\OneToMany(mappedBy: 'StudetnID', targetEntity: SocialNetwork::class)]
    private Collection $socialNetworks;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: PersonalDocuments::class)]
    private Collection $personalDocuments;

    private ?Gender $gender = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\OneToOne(targetEntity: User::class, mappedBy: 'student')]
    private ?User $user = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Photo = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?StudentGroup $studentGroup = null;

    private ?int $StudentGroup = null;
    #[ORM\Column(nullable: true)]
    private ?bool $IsOrphan = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsPaid = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsInvalid = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsPoor = null;

    #[ORM\Column(nullable: true)]
    private ?int $PasportNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PasportSeries = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?DateTimeInterface $PasportDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $PasportIssueOrgan = null;

    #[ORM\OneToMany(targetEntity: Characteristic::class, mappedBy: 'Student')]
    private Collection $characteristics;

    #[ORM\Column(nullable: true)]
    private ?bool $isWithoutParents = null;

    #[ORM\ManyToOne(inversedBy: 'student')]
    private ?AbiturientPetition $abiturientPetition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $FirstPassword = null;

    #[ORM\OneToMany(targetEntity: AccessSystemControl::class, mappedBy: 'Student')]
    private Collection $accessSystemControls;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UUID = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isLiveStudentAccommondation = null;

    private ?bool $punishmentStatus;


    private StudentService $studentService;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: LoginValues::class)]
    private Collection $loginValues;

    #[ORM\ManyToMany(targetEntity: \App\mod_events\Entity\EventsList::class, mappedBy: 'EventParticipant')]
    private Collection $eventsLists;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: EventsResult::class)]
    private Collection $eventsResults;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: StudentPunishment::class)]
    private Collection $studentPunishments;


    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: GroupMembership::class)]
    private Collection $groupMemberships;

    #[ORM\ManyToOne(inversedBy: 'student')]
    #[Groups(['student:list', 'student:item'])]
    private ?Person $person = null;


    public function __construct()
    {
        $this->legalRepresentatives = new ArrayCollection();
        $this->socialNetworks = new ArrayCollection();
        $this->personalDocuments = new ArrayCollection();
        $this->personalDocuments->getValues();
        $this->characteristics = new ArrayCollection();
        $this->accessSystemControls = new ArrayCollection();
        $this->loginValues = new ArrayCollection();
        $this->eventsLists = new ArrayCollection();
        $this->eventsResults = new ArrayCollection();
        $this->studentPunishments = new ArrayCollection();
        $this->groupMemberships = new ArrayCollection();
        if ($this->person) {
            $this->gender = $this->person->getGender();
        }
    }


    public function getAsJson():array
    {
        return get_object_vars($this);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumberZachetka(): ?string
    {
        return $this->NumberZachetka;
    }

    public function setNumberZachetka(?string $NumberZachetka): self
    {
        $this->NumberZachetka = $NumberZachetka;

        return $this;
    }

    public function getNumberStudBilet(): ?string
    {
        return $this->NumberStudBilet;
    }

    public function setNumberStudBilet(?string $NumberStudBilet): self
    {
        $this->NumberStudBilet = $NumberStudBilet;

        return $this;
    }

    public function getBirthDate(): ?DateTimeInterface
    {
       return $this->person->getBirthDate();
    }

    public function setBirthDate(?DateTimeInterface $BirthDate): self
    {
        $this->person->setBirthDate($BirthDate);

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(int $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
      return $this->person->getFirstName();
    }

    public function setFirstName(string $FirstName): self
    {
        $this->person->setFirstName($FirstName);

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->person->getLastName();
    }

    public function setLastName(string $LastName): self
    {
        $this->person->setLastName($LastName);
        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->person->getMiddleName();
    }

    public function getFullName(): ?string
    {
        return $this->getLastName() . " " . $this->getFirstName() . " " . $this->getMiddleName();
    }

    public function setMiddleName(?string $MiddleName): self
    {
        $this->person->setMiddleName($MiddleName);
        return $this;
    }

    public function getDocumentSnils(): ?Snils
    {
        return $this->person->getSNILS();
    }

    public function setDocumentSnils(?Snils $DocumentSnils): self
    {
        $this->DocumentSnils = $DocumentSnils;
        $this->person->setSNILS($DocumentSnils);
        return $this;
    }

    public function getDocumentMedicalID(): ?string
    {
        return $this->DocumentMedicalID;
    }

    public function setDocumentMedicalID(?string $DocumentMedicalID): self
    {
        $this->DocumentMedicalID = $DocumentMedicalID;

        return $this;
    }

    public function getAddressFact(): ?string
    {
        return $this->AddressFact;
    }

    public function setAddressFact(?string $AddressFact): self
    {
        $this->AddressFact = $AddressFact;

        return $this;
    }

    public function getAddressMain(): ?string
    {
        return $this->AddressMain;
    }

    public function setAddressMain(?string $AddressMain): self
    {
        $this->AddressMain = $AddressMain;

        return $this;
    }

    public function getFamilyTypeID(): ?FamilyTypeList
    {
        return $this->familyTypeID;
    }

    public function setFamilyTypeID(?FamilyTypeList $familyTypeID): self
    {
        $this->familyTypeID = $familyTypeID;

        return $this;
    }

    /**
     * @return Collection<int, LegalRepresentative>
     */
    public function getLegalRepresentatives(): Collection
    {
        return $this->legalRepresentatives;
    }

    public function addLegalRepresentative(LegalRepresentative $legalRepresentative): self
    {
        if (!$this->legalRepresentatives->contains($legalRepresentative)) {
            $this->legalRepresentatives->add($legalRepresentative);
            $legalRepresentative->setStudentID($this);
        }

        return $this;
    }

    public function removeLegalRepresentative(LegalRepresentative $legalRepresentative): self
    {
        if ($this->legalRepresentatives->removeElement($legalRepresentative)) {
            // set the owning side to null (unless already changed)
            if ($legalRepresentative->getStudentID() === $this) {
                $legalRepresentative->setStudentID(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SocialNetwork>
     */
    public function getSocialNetworks(): Collection
    {
        return $this->socialNetworks;
    }

    public function addSocialNetwork(SocialNetwork $socialNetwork): self
    {
        if (!$this->socialNetworks->contains($socialNetwork)) {
            $this->socialNetworks->add($socialNetwork);
            $socialNetwork->setStudetnID($this);
        }

        return $this;
    }

    public function removeSocialNetwork(SocialNetwork $socialNetwork): self
    {
        if ($this->socialNetworks->removeElement($socialNetwork)) {
            // set the owning side to null (unless already changed)
            if ($socialNetwork->getStudetnID() === $this) {
                $socialNetwork->setStudetnID(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonalDocuments>
     */
    public function getPersonalDocuments(): Collection
    {
        return $this->personalDocuments;
    }

    public function addPersonalDocument(PersonalDocuments $personalDocument): self
    {
        if (!$this->personalDocuments->contains($personalDocument)) {
            $this->personalDocuments->add($personalDocument);
            $personalDocument->setStudent($this);
        }

        return $this;
    }

    public function removePersonalDocument(PersonalDocuments $personalDocument): self
    {
        if ($this->personalDocuments->removeElement($personalDocument)) {
            // set the owning side to null (unless already changed)
            if ($personalDocument->getStudent() === $this) {
                $personalDocument->setStudent(null);
            }
        }

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;
        return $this;
    }

    public function __toString()
    {
        return (string)$this->getLastName() . ' ' . $this->getFirstName() . ' ' . $this->getMiddleName();
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }




    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(?string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getStudentGroup(): ?StudentGroup
    {
        return $this->StudentGroup;
    }

    public function setStudentGroup(?StudentGroup $studentGroup): self
    {

        $this->StudentGroup = $studentGroup;
        return $this;
    }

    public function isIsOrphan(): ?bool
    {
        return $this->IsOrphan;
    }

    public function setIsOrphan(?bool $IsOrphan): self
    {
        $this->IsOrphan = $IsOrphan;
        return $this;
    }

    public function isIsPaid(): ?bool
    {
        return $this->IsPaid;
    }

    public function setIsPaid(?bool $IsPaid): self
    {
        $this->IsPaid = $IsPaid;
        return $this;
    }

    public function isIsInvalid(): ?bool
    {
        return $this->IsInvalid;
    }

    public function setIsInvalid(?bool $IsInvalid): self
    {
        $this->IsInvalid = $IsInvalid;
        return $this;
    }

    public function isIsPoor(): ?bool
    {
        return $this->IsPoor;
    }

    public function setIsPoor(?bool $IsPoor): self
    {
        $this->IsPoor = $IsPoor;
        return $this;
    }

    public function getPasportNumber(): ?int
    {
        return $this->PasportNumber;
    }

    public function setPasportNumber(?int $PasportNumber): self
    {
        $this->PasportNumber = $PasportNumber;

        return $this;
    }

    public function getPasportSeries(): ?string
    {
        return $this->PasportSeries;
    }

    public function setPasportSeries(string $PasportSeries): self
    {
        $this->PasportSeries = $PasportSeries;
        return $this;
    }

    public function getPasportDate(): ?DateTimeInterface
    {
        return $this->PasportDate;
    }

    public function setPasportDate(DateTimeInterface $PasportDate): self
    {
        $this->PasportDate = $PasportDate;
        return $this;
    }

    public function getPasportIssueOrgan(): ?string
    {
        return $this->PasportIssueOrgan;
    }

    public function setPasportIssueOrgan(?string $PasportIssueOrgan): self
    {
        $this->PasportIssueOrgan = $PasportIssueOrgan;
        return $this;
    }

    /**
     * @return Collection<int, Characteristic>
     */
    public function getCharacteristics(): Collection
    {
        return $this->characteristics;
    }

    public function addCharacteristic(Characteristic $characteristic): self
    {
        if (!$this->characteristics->contains($characteristic)) {
            $this->characteristics->add($characteristic);
            $characteristic->setStudent($this);
        }

        return $this;
    }

    public function removeCharacteristic(Characteristic $characteristic): self
    {
        if ($this->characteristics->removeElement($characteristic)) {
            // set the owning side to null (unless already changed)
            if ($characteristic->getStudent() === $this) {
                $characteristic->setStudent(null);
            }
        }

        return $this;
    }

    public function isIsWithoutParents(): ?bool
    {
        return $this->isWithoutParents;
    }

    public function setIsWithoutParents(?bool $isWithoutParents): self
    {
        $this->isWithoutParents = $isWithoutParents;
        return $this;
    }

    public function getAbiturientPetition(): ?AbiturientPetition
    {
        return $this->abiturientPetition;
    }

    public function setAbiturientPetition(?AbiturientPetition $abiturientPetition): static
    {
        $this->abiturientPetition = $abiturientPetition;
        return $this;
    }

    public function getFirstPassword(): ?string
    {
        return $this->FirstPassword;
    }

    public function setFirstPassword(?string $FirstPassword): static
    {
        $this->FirstPassword = $FirstPassword;
        return $this;
    }

    /**
     * @return Collection<int, AccessSystemControl>
     */
    public function getAccessSystemControls(): Collection
    {
        return $this->accessSystemControls;
    }

    public function addAccessSystemControl(AccessSystemControl $accessSystemControl): static
    {
        if (!$this->accessSystemControls->contains($accessSystemControl)) {
            $this->accessSystemControls->add($accessSystemControl);
            $accessSystemControl->setStudent($this);
        }
        return $this;
    }

    public function removeAccessSystemControl(AccessSystemControl $accessSystemControl): static
    {
        if ($this->accessSystemControls->removeElement($accessSystemControl)) {
            // set the owning side to null (unless already changed)
            if ($accessSystemControl->getStudent() === $this) {
                $accessSystemControl->setStudent(null);
            }
        }
        return $this;
    }

    public function getUUID(): ?string
    {
        return $this->UUID;
    }

    public function setUUID(?string $UUID): static
    {
        $this->UUID = $UUID;
        return $this;
    }

    public function isIsLiveStudentAccommondation(): ?bool
    {
        return $this->isLiveStudentAccommondation;
    }

    public function setIsLiveStudentAccommondation(?bool $isLiveStudentAccommondation): static
    {
        $this->isLiveStudentAccommondation = $isLiveStudentAccommondation;
        return $this;
    }

    /**
     * @return Collection<int, LoginValues>
     */
    public function getLoginValues(): Collection
    {
        return $this->loginValues;
    }

    public function addLoginValue(LoginValues $loginValue): static
    {
        if (!$this->loginValues->contains($loginValue)) {
            $this->loginValues->add($loginValue);
            $loginValue->setStudent($this);
        }
        return $this;
    }

    public function removeLoginValue(LoginValues $loginValue): static
    {
        if ($this->loginValues->removeElement($loginValue)) {
            // set the owning side to null (unless already changed)
            if ($loginValue->getStudent() === $this) {
                $loginValue->setStudent(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, EventsList>
     */
    public function getEventsLists(): Collection
    {
        return $this->eventsLists;
    }

    public function addEventsList(EventsList $eventsList): static
    {
        if (!$this->eventsLists->contains($eventsList)) {
            $this->eventsLists->add($eventsList);
            $eventsList->addEventParticipant($this);
        }

        return $this;
    }

    public function removeEventsList(\App\mod_events\Entity\EventsList $eventsList): static
    {
        if ($this->eventsLists->removeElement($eventsList)) {
            $eventsList->removeEventParticipant($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, EventsResult>
     */
    public function getEventsResults(): Collection
    {
        return $this->eventsResults;
    }

    public function addEventsResult(EventsResult $eventsResult): static
    {
        if (!$this->eventsResults->contains($eventsResult)) {
            $this->eventsResults->add($eventsResult);
            $eventsResult->setStudent($this);
        }
        return $this;
    }

    public function removeEventsResult(EventsResult $eventsResult): static
    {
        if ($this->eventsResults->removeElement($eventsResult)) {
            // set the owning side to null (unless already changed)
            if ($eventsResult->getStudent() === $this) {
                $eventsResult->setStudent(null);
            }
        }
        return $this;
    }

    public function isMale(): bool
    {

        if ($this->getGender() && ($this->getGender()->getGenderName() == "MALE")) {
            return true;
        }
        return false;
    }

    public function getPunishmentStatus(): bool
    {
        $this->getStudentPunishments();
        return $this->punishmentStatus;
    }

    public function setPunishmentStatus($value): void
    {
        $this->punishmentStatus = $value;
    }

    public function definePunishmentStatus(): bool
    {
        if ($this->studentPunishments->getValues()) {
            /***
             * @var StudentPunishment $item
             */
            foreach ($this->studentPunishments->getValues() as $item) {
                if (((int)date_create('now')->diff($item->getDate())->y) == 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isAdult(): bool
    {
        if (((int)date_create('now')->diff($this->getBirthDate())->y) >= 18) {
            return true;
        }
        return false;

    }

    /**
     * @return Collection<int, StudentPunishment>
     */
    public function getStudentPunishments(): Collection
    {
        $this->setPunishmentStatus($this->definePunishmentStatus());
        return $this->studentPunishments;
    }

    public function addStudentPunishment(StudentPunishment $studentPunishment): static
    {
        if (!$this->studentPunishments->contains($studentPunishment)) {
            $this->studentPunishments->add($studentPunishment);
            $studentPunishment->setStudent($this);
        }
        return $this;
    }

    public function removeStudentPunishment(StudentPunishment $studentPunishment): static
    {
        if ($this->studentPunishments->removeElement($studentPunishment)) {
            // set the owning side to null (unless already changed)
            if ($studentPunishment->getStudent() === $this) {
                $studentPunishment->setStudent(null);
            }
        }
        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): static
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return Collection<int, GroupMembership>
     */
    public function getGroupMembership(): Collection
    {
        return $this->groupMembership;
    }

    public function setGroupMembership(Collection $groupMembership): void
    {
        $this->groupMembership = $groupMembership;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getHealthGroupID(): ?HealthGroup
    {
        return $this->healthGroupID;
    }

    public function setHealthGroupID(?HealthGroup $healthGroupID): void
    {
        $this->healthGroupID = $healthGroupID;
    }
}
