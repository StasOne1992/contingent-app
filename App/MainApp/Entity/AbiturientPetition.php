<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\AbiturientPetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbiturientPetitionRepository::class)]
class AbiturientPetition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $GUID = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;
    private ?string $firstName = null;
    private ?string $lastName = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $middleName = null;
    private ?string $documentSNILS = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdTs = null;

    #[ORM\ManyToOne(inversedBy: 'abiturientPetitions')]
    private ?Gender $Gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $registrationAddress = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $currentLocationAddress = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $birthPlace = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $pasport_issue_organ = null;

    #[ORM\ManyToOne(inversedBy: 'abiturientPetitions')]
    private ?AbiturientPetitionStatus $status = null;

    #[ORM\Column(nullable: true)]
    private ?bool $documentObtained = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $uploadTS = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $lastUpdateTS = null;

    //#[ORM\GeneratedValue(strategy: 'SEQUENCE')]
   // #[ORM\SequenceGenerator(sequenceName: 'abiturient_petition_local_number_seq',initialValue: 372)]
    //#[ORM\Column( nullable: true,options: ['default'=>'nextval(\'abiturient_petition_local_number_seq\')'])]
    #[ORM\Column( nullable: true)]
    private ?int $localNumber = null;

    #[ORM\Column(nullable: true)]
    private ?float $educationDocumentGPA = null;

    #[ORM\ManyToOne(inversedBy: 'abiturientPetitions')]
    private ?Admission $admission = null;

    #[ORM\ManyToOne(inversedBy: 'abiturientPetitions')]
    private ?Faculty $Faculty = null;

    #[ORM\Column(nullable: true)]
    private ?bool $canceled = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $PasportSeries = null;

    #[ORM\Column(nullable: true)]
    private ?int $PasportNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $PasportDateObtain = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LoadToFISGIA = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Comment = null;

    #[ORM\Column(nullable: true)]
    private ?bool $CanPay = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $SchoolName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EducationDocumentName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $EducationDocumentNumber = null;
    #[ORM\Column(nullable: true)]
    private ?bool $HaveErrorInPetition = null;
    #[ORM\ManyToOne(inversedBy: 'abiturientPetitions')]
    private ?Regions $Region = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumberProvision = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateProvision = null;

    #[ORM\Column(nullable: true)]
    private ?int $NumberCancel = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $DateCancel = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $CancelReason = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsOrphan = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsInvalid = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsPoor = null;

    #[ORM\Column(nullable: true)]
    private ?bool $NeedStudentAccommondation = null;

    #[ORM\Column(nullable: true)]
    private ?array $Attaches = null;


    private ?\DateTimeInterface $BirthDate = null;

    #[ORM\Column(nullable: true)]
    private ?bool $LockUpdateFormVIS = null;

    #[ORM\OneToMany(mappedBy: 'AbiturientPetition', targetEntity: AdmissionExaminationResult::class)]
    private Collection $AdmissionExaminationResult;

    #[ORM\ManyToOne(inversedBy: 'abiturientPetitions')]
    private ?AdmissionPlan $AdmissionPlanPosition = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $potok = null;

    #[ORM\Column(nullable: true)]
    private ?bool $HasTargetAgreement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $TargetAgreementNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $TargetAgreementDate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $TargetAgreementEmployer = null;

    #[ORM\OneToMany(mappedBy: 'AbiturientPetition', targetEntity: Student::class)]
    private Collection $students;

    #[ORM\Column(nullable: true)]
    private ?bool $isBlockedToEdit = null;

    #[ORM\ManyToOne(inversedBy: 'AbiturientPetition', cascade: ['persist'])]
    private ?Person $person = null;

    public function __construct()
    {
        if (!$this->getPerson()) {
            $this->person = new Person();
        };
        $this->Result = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGUID(): ?string
    {
        return $this->GUID;
    }

    public function setGUID(string $GUID): self
    {
        $this->GUID = $GUID;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->person->getFirstName();
    }

    public function setFirstName(string $firstName): self
    {
        $this->person->setFirstName($firstName);
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->person->getLastName();
    }

    public function setLastName(string $lastName): self
    {
        $this->person->setLastName($lastName);
        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->person->getMiddleName();
    }

    public function setMiddleName(?string $middleName): self
    {
        $this->getPerson()->setMiddleName($middleName);
        return $this;
    }

    public function getDocumentSNILS(): ?string
    {
        return $this->person->getSNILS();
    }

    public function setDocumentSNILS(?string $documentSNILS): self
    {
        $this->getPerson()->setSNILS($documentSNILS);
        return $this;
    }

    public function getCreatedTs(): ?\DateTimeInterface
    {
        return $this->createdTs;
    }

    public function setCreatedTs(?\DateTimeInterface $createdTs): static
    {
        $this->createdTs = $createdTs;

        return $this;
    }
    public function __toString(): string
    {
        return $this->getNumber().' '.$this->getLastName().' '.$this->getFirstName().' '.$this->getMiddleName();
    }

    public function getGender(): ?Gender
    {
        return $this->Gender;
    }

    public function setGender(?Gender $Gender): static
    {
        $this->Gender = $Gender;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getregistrationAddress(): ?string
    {
        return $this->registrationAddress;
    }

    public function setregistrationAddress(?string $registrationAddress): static
    {
        $this->registrationAddress = $registrationAddress;

        return $this;
    }

    public function getCurrentLocationAddress(): ?string
    {
        return $this->currentLocationAddress;
    }

    public function setCurrentLocationAddress(?string $currentLocationAddress): static
    {
        $this->currentLocationAddress = $currentLocationAddress;

        return $this;
    }

    public function getBirthPlace(): ?string
    {
        return $this->birthPlace;
    }

    public function setBirthPlace(?string $birthPlace): static
    {
        $this->birthPlace = $birthPlace;

        return $this;
    }

    public function getPasportIssueOrgan(): ?string
    {
        return $this->pasport_issue_organ;
    }

    public function setPasportIssueOrgan(?string $pasport_issue_organ): static
    {
        $this->pasport_issue_organ = $pasport_issue_organ;

        return $this;
    }

    public function getStatus(): ?AbiturientPetitionStatus
    {
        return $this->status;
    }

    public function setStatus(?AbiturientPetitionStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function isDocumentObtained(): ?bool
    {
        return $this->documentObtained;
    }

    public function setDocumentObtained(?bool $documentObtained): static
    {
        $this->documentObtained = $documentObtained;

        return $this;
    }

    public function getUploadTS(): ?\DateTimeInterface
    {
        return $this->uploadTS;
    }

    public function setUploadTS(?\DateTimeInterface $uploadTS): static
    {
        $this->uploadTS = $uploadTS;

        return $this;
    }

    public function getLastUpdateTS(): ?\DateTimeInterface
    {
        return $this->lastUpdateTS;
    }

    public function setLastUpdateTS(?\DateTimeInterface $lastUpdateTS): static
    {
        $this->lastUpdateTS = $lastUpdateTS;

        return $this;
    }

    public function getLocalNumber(): ?string
    {
        return $this->localNumber;
    }

    public function setLocalNumber(?string $localNumber): static
    {
        $this->localNumber = $localNumber;

        return $this;
    }

    public function getEducationDocumentGPA(): ?float
    {
        return $this->educationDocumentGPA;
    }

    public function setEducationDocumentGPA(?float $educationDocumentGPA): static
    {
        $this->educationDocumentGPA = $educationDocumentGPA;

        return $this;
    }

    public function getAdmission(): ?Admission
    {
        return $this->admission;
    }

    public function setAdmission(?Admission $admission): static
    {
        $this->admission = $admission;

        return $this;
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

    public function isCanceled(): ?bool
    {
        return $this->canceled;
    }

    public function setCanceled(?bool $canceled): static
    {
        $this->canceled = $canceled;

        return $this;
    }

    public function getPasportSeries(): ?string
    {
        return $this->PasportSeries;
    }

    public function setPasportSeries(?string $PasportSeries): static
    {
        $this->PasportSeries = $PasportSeries;

        return $this;
    }

    public function getPasportNumber(): ?int
    {
        return $this->PasportNumber;
    }

    public function setPasportNumber(?int $PasportNumber): static
    {
        $this->PasportNumber = $PasportNumber;

        return $this;
    }

    public function getPasportDateObtain(): ?\DateTimeInterface
    {
        return $this->PasportDateObtain;
    }

    public function setPasportDateObtain(?\DateTimeInterface $PasportDateObtain): static
    {
        $this->PasportDateObtain = $PasportDateObtain;

        return $this;
    }

    public function isLoadToFISGIA(): ?bool
    {
        return $this->LoadToFISGIA;
    }

    public function setLoadToFISGIA(?bool $LoadToFISGIA): static
    {
        $this->LoadToFISGIA = $LoadToFISGIA;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(?string $Comment): static
    {
        $this->Comment = $Comment;

        return $this;
    }

    public function isCanPay(): ?bool
    {
        return $this->CanPay;
    }

    public function setCanPay(?bool $CanPay): static
    {
        $this->CanPay = $CanPay;

        return $this;
    }

    public function getSchoolName(): ?string
    {
        return $this->SchoolName;
    }

    public function setSchoolName(?string $SchoolName): static
    {
        $this->SchoolName = $SchoolName;

        return $this;
    }

    public function getEducationDocumentName(): ?string
    {
        return $this->EducationDocumentName;
    }

    public function setEducationDocumentName(?string $EducationDocumentName): static
    {
        $this->EducationDocumentName = $EducationDocumentName;

        return $this;
    }

    public function getEducationDocumentNumber(): ?string
    {
        return $this->EducationDocumentNumber;
    }

    public function setEducationDocumentNumber(?string $EducationDocumentNumber): static
    {
        $this->EducationDocumentNumber = $EducationDocumentNumber;

        return $this;
    }

    public function isHaveErrorInPetition(): ?bool
    {
        return $this->HaveErrorInPetition;
    }

    public function setHaveErrorInPetition(?bool $HaveErrorInPetition): static
    {
        $this->HaveErrorInPetition = $HaveErrorInPetition;

        return $this;
    }

    public function getRegion(): ?Regions
    {
        return $this->Region;
    }

    public function setRegion(?Regions $Region): static
    {
        $this->Region = $Region;

        return $this;
    }

    public function getNumberProvision(): ?int
    {
        return $this->NumberProvision;
    }

    public function setNumberProvision(?int $NumberProvision): static
    {
        $this->NumberProvision = $NumberProvision;

        return $this;
    }

    public function getDateProvision(): ?\DateTimeInterface
    {
        return $this->DateProvision;
    }

    public function setDateProvision(?\DateTimeInterface $DateProvision): static
    {
        $this->DateProvision = $DateProvision;

        return $this;
    }

    public function getNumberCancel(): ?int
    {
        return $this->NumberCancel;
    }

    public function setNumberCancel(?int $NumberCancel): static
    {
        $this->NumberCancel = $NumberCancel;

        return $this;
    }

    public function getDateCancel(): ?\DateTimeInterface
    {
        return $this->DateCancel;
    }

    public function setDateCancel(?\DateTimeInterface $DateCancel): static
    {
        $this->DateCancel = $DateCancel;

        return $this;
    }

    public function getCancelReason(): ?string
    {
        return $this->CancelReason;
    }

    public function setCancelReason(?string $CancelReason): static
    {
        $this->CancelReason = $CancelReason;

        return $this;
    }

    public function isIsOrphan(): ?bool
    {
        return $this->IsOrphan;
    }

    public function setIsOrphan(?bool $IsOrphan): static
    {
        $this->IsOrphan = $IsOrphan;

        return $this;
    }

    public function isIsInvalid(): ?bool
    {
        return $this->IsInvalid;
    }

    public function setIsInvalid(?bool $IsInvalid): static
    {
        $this->IsInvalid = $IsInvalid;

        return $this;
    }

    public function isIsPoor(): ?bool
    {
        return $this->IsPoor;
    }

    public function setIsPoor(?bool $IsPoor): static
    {
        $this->IsPoor = $IsPoor;

        return $this;
    }

    public function isNeedStudentAccommondation(): ?bool
    {
        return $this->NeedStudentAccommondation;
    }

    public function setNeedStudentAccommondation(?bool $NeedStudentAccommondation): static
    {
        $this->NeedStudentAccommondation = $NeedStudentAccommondation;

        return $this;
    }

    public function getAttaches(): ?array
    {
        return $this->Attaches;
    }

    public function setAttaches(?array $Attaches): static
    {
        $this->Attaches = $Attaches;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->person->getBirthDate();
    }

    public function setBirthDate(?\DateTimeInterface $BirthDate): static
    {

        $this->person->setBirthDate($BirthDate);
        return $this;
    }

    public function isLockUpdateFormVIS(): ?bool
    {
        return $this->LockUpdateFormVIS;
    }

    public function setLockUpdateFormVIS(?bool $LockUpdateFormVIS): static
    {
        $this->LockUpdateFormVIS = $LockUpdateFormVIS;

        return $this;
    }

    /**
     * @return Collection<int, AdmissionExaminationResult>
     */
    public function getResult(): Collection
    {
        return $this->AdmissionExaminationResult;
    }

    public function addResult(AdmissionExaminationResult $AdmissionExaminationResult): static
    {
        if (!$this->AdmissionExaminationResult->contains($AdmissionExaminationResult)) {
            $this->AdmissionExaminationResult->add($AdmissionExaminationResult);
            $AdmissionExaminationResult->setAbiturientPetition($this);
        }

        return $this;
    }

    public function removeResult(AdmissionExaminationResult $AdmissionExaminationResult): static
    {
        if ($this->AdmissionExaminationResult->removeElement($AdmissionExaminationResult)) {
            // set the owning side to null (unless already changed)
            if ($AdmissionExaminationResult->getAbiturientPetition() === $this) {
                $AdmissionExaminationResult->setAbiturientPetition(null);
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

    public function getPotok(): ?string
    {
        return $this->potok;
    }

    public function setPotok(?string $potok): static
    {
        $this->potok = $potok;

        return $this;
    }

    public function isHasTargetAgreement(): ?bool
    {
        return $this->HasTargetAgreement;
    }

    public function setHasTargetAgreement(?bool $HasTargetAgreement): static
    {
        $this->HasTargetAgreement = $HasTargetAgreement;

        return $this;
    }

    public function getTargetAgreementNumber(): ?string
    {
        return $this->TargetAgreementNumber;
    }

    public function setTargetAgreementNumber(?string $TargetAgreementNumber): static
    {
        $this->TargetAgreementNumber = $TargetAgreementNumber;

        return $this;
    }

    public function getTargetAgreementDate(): ?\DateTimeInterface
    {
        return $this->TargetAgreementDate;
    }

    public function setTargetAgreementDate(?\DateTimeInterface $TargetAgreementDate): static
    {
        $this->TargetAgreementDate = $TargetAgreementDate;

        return $this;
    }

    public function getTargetAgreementEmployer(): ?string
    {
        return $this->TargetAgreementEmployer;
    }

    public function setTargetAgreementEmployer(?string $TargetAgreementEmployer): static
    {
        $this->TargetAgreementEmployer = $TargetAgreementEmployer;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setAbiturientPetition($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getAbiturientPetition() === $this) {
                $student->setAbiturientPetition(null);
            }
        }

        return $this;
    }

    public function isIsBlockedToEdit(): ?bool
    {
        return $this->isBlockedToEdit;
    }

    public function setIsBlockedToEdit(?bool $isBlockedToEdit): static
    {
        $this->isBlockedToEdit = $isBlockedToEdit;

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
