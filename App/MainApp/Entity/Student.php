<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\StudentRepository;
use App\MainApp\Service\StudentService;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
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

    private ?string $FirstName = null;

    private ?string $LastName = null;

    private ?string $MiddleName = null;

    private ?string $DocumentSnils = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DocumentMedicalID = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AddressFact = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $AddressMain = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?FamilyTypeList $FamilyTypeID = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?HealthGroup $HealtgGroupID = null;

    #[ORM\OneToMany(mappedBy: 'StudentID', targetEntity: LegalRepresentative::class)]
    private Collection $legalRepresentatives;

    #[ORM\OneToMany(mappedBy: 'StudetnID', targetEntity: SocialNetwork::class)]
    private Collection $socialNetworks;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: PersonalDocuments::class)]
    private Collection $personalDocuments;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?Gender $Gender = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isActive = null;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Photo = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?StudentGroups $StudentGroup = null;

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

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: Characteristic::class)]
    private Collection $characteristics;

    #[ORM\Column(nullable: true)]
    private ?bool $isWithoutParents = null;

    #[ORM\ManyToMany(targetEntity: ContingentDocument::class, mappedBy: 'student')]
    private Collection $contingentDocuments;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?AbiturientPetition $AbiturientPetition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $FirstPassword = null;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: AccessSystemControl::class)]
    private Collection $accessSystemControls;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UUID = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isLiveStudentAccommondation = null;

    private ?bool $punishmentStatus;

    public function __construct()
    {
        $this->legalRepresentatives = new ArrayCollection();
        $this->socialNetworks = new ArrayCollection();
        $this->personalDocuments = new ArrayCollection();
        $this->personalDocuments->getValues();
        $this->users = new ArrayCollection();
        $this->characteristics = new ArrayCollection();
        $this->contingentDocuments = new ArrayCollection();
        $this->accessSystemControls = new ArrayCollection();
        $this->loginValues = new ArrayCollection();
        $this->eventsLists = new ArrayCollection();
        $this->eventsResults = new ArrayCollection();
        $this->studentPunishments = new ArrayCollection();
        if (!$this->getPerson()) {
            $this->person = new Person();
            $this->person->setBirthDate(date_create('1900-01-01'));
        }
    }


    public function getAsJson():array
    {
        return get_object_vars($this);
    }
    private StudentService $studentService;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: LoginValues::class)]
    private Collection $loginValues;

    #[ORM\ManyToMany(targetEntity: EventsList::class, mappedBy: 'EventParticipant')]
    private Collection $eventsLists;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: EventsResult::class)]
    private Collection $eventsResults;

    #[ORM\OneToMany(mappedBy: 'Student', targetEntity: StudentPunishment::class)]
    private Collection $studentPunishments;

    #[ORM\ManyToOne(inversedBy: 'student')]
    private ?Person $person = null;

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

    public function getDocumentSnils(): ?string
    {
        return $this->person->getSNILS();
    }

    public function setDocumentSnils(?string $DocumentSnils): self
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
        return $this->FamilyTypeID;
    }

    public function setFamilyTypeID(?FamilyTypeList $FamilyTypeID): self
    {
        $this->FamilyTypeID = $FamilyTypeID;

        return $this;
    }

    public function getHealtgGroupID(): ?HealthGroup
    {
        return $this->HealtgGroupID;
    }

    public function setHealtgGroupID(?HealthGroup $HealtgGroupID): self
    {
        $this->HealtgGroupID = $HealtgGroupID;

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
        return $this->Gender;
    }

    public function setGender(?Gender $Gender): self
    {
        $this->Gender = $Gender;

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setStudentID($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStudentID() === $this) {
                $user->setStudentID(null);
            }
        }

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

    public function getStudentGroup(): ?StudentGroups
    {
        return $this->StudentGroup;
    }

    public function setStudentGroup(?StudentGroups $StudentGroup): self
    {

        $this->StudentGroup = $StudentGroup;
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

    /**
     * @return Collection<int, ContingentDocument>
     */
    public function getContingentDocuments(): Collection
    {
        return $this->contingentDocuments;
    }

    public function addContingentDocument(ContingentDocument $contingentDocument): self
    {
        if (!$this->contingentDocuments->contains($contingentDocument)) {
            $this->contingentDocuments->add($contingentDocument);
            $contingentDocument->addStudent($this);
        }

        return $this;
    }

    public function removeContingentDocument(ContingentDocument $contingentDocument): self
    {
        if ($this->contingentDocuments->removeElement($contingentDocument)) {
            $contingentDocument->removeStudent($this);
        }

        return $this;
    }

    public function getAbiturientPetition(): ?AbiturientPetition
    {
        return $this->AbiturientPetition;
    }

    public function setAbiturientPetition(?AbiturientPetition $AbiturientPetition): static
    {
        $this->AbiturientPetition = $AbiturientPetition;

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

    public function removeEventsList(EventsList $eventsList): static
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
}
