<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\AdmissionExaminationResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdmissionExaminationResultRepository::class)]
class AdmissionExaminationResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'Result')]
    private ?AbiturientPetition $AbiturientPetition = null;

    #[ORM\Column]
    private ?float $Mark = null;

    #[ORM\ManyToOne(inversedBy: 'admissionExaminationResults')]
    private ?AdmissionExamination $AdmissionExamination = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMark(): ?float
    {
        return $this->Mark;
    }

    public function setMark(float $Mark): static
    {
        $this->Mark = $Mark;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getAdmissionExamination()->getDate()->format('d-m-Y').' '.$this->getAdmissionExamination()->getExaminationSubject();
    }


    public function getAdmissionExamination(): ?AdmissionExamination
    {
        return $this->AdmissionExamination;
    }

    public function setAdmissionExamination(?AdmissionExamination $AdmissionExamination): static
    {
        $this->AdmissionExamination = $AdmissionExamination;

        return $this;
    }
}
