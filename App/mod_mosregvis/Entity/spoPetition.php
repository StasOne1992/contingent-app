<?php

namespace App\mod_mosregvis\Entity;

use App\MainApp\Entity\Gender;
use App\MainApp\Entity\Person;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

class spoPetition
{

    #[ORM\Id, ORM\GeneratedValue(strategy: 'SEQUENCE'), ORM\Column]
    private int|null $id = null;
    private string $guid = "";
    private float $number = 0;
    private ?Person $person;
    /**
     * @ORM\Column(type="snils", nullable=true, options={"unsigned": true, "comment": "СНИЛС"})
     *
     * @var Snils СНИЛС
     */
    //[ORM\Column(type: 'snils', nullable: true, options: ['unsigned' => true, 'comment' => 'СНИЛС'])]
    protected Snils|null $snils = null;
    private string $phone;
    private string $email;
    private Gender $gender;
    private string $inn;
    private bool $canceled = false;
    private bool $agreePersonalDataProcessing = false;
    private bool $needDormitory = false;
    private bool $isFirstEdu = false;
    private bool $checkAccreditation = false;
    private bool $checkLicense = false;
    private bool $knowOrganizationRules = false;
    private bool $emailNotification = false;
    private \DateTime $provideOrigDocDate;
    private \DateTime $basicEducationEndYear;
    private \DateTime $createdTs;
    private float $educationDocumentGPA = 0.0;
    private string $basicEducationOrganizationPlain = "";
    private reference_SpoEducationYear $year;
    private string $documentId = "";
    private \DateTime $birthDate;
    private string $birthPlace = "";
    private string $subdivisionCode;
    private string $documentSource = "";
    private string $documentSeries = "";
    private Integer $documentNumber;
    private \DateTime $documentDateObtain;
    private string $nationalityName = "";
    private string $nationalityTitle = "";
    private string $firstName = "";
    private string $lastName = "";
    private string $middleName = "";
}