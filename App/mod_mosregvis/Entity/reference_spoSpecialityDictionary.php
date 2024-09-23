<?php

namespace App\mod_mosregvis\Entity;

use App\mod_mosregvis\Repository\reference_spoSpecialityDictionaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: reference_spoSpecialityDictionaryRepository::class)]
class reference_spoSpecialityDictionary
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?string $code = null;
    #[ORM\Column(length: 255)]
    private ?string $name = null;
    #[ORM\Column(type: Types::TEXT)]
    private ?string $qualification = null;
    #[ORM\Column (nullable: true)]
    private ?int $idVis = null;
    #[ORM\ManyToOne(targetEntity: reference_trainingProgramGradation::class, inversedBy: 'spoSpeciality')]
    private ?reference_trainingProgramGradation $trainingProgramGradation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getQualification(): ?string
    {
        return $this->qualification;
    }

    public function setQualification(?string $qualification): void
    {
        $this->qualification = $qualification;
    }

    public function getTrainingProgramGradation(): ?reference_trainingProgramGradation
    {
        return $this->trainingProgramGradation;
    }

    public function setTrainingProgramGradation(?reference_trainingProgramGradation $trainingProgramGradation): void
    {
        $this->trainingProgramGradation = $trainingProgramGradation;
    }

    public function getIdVis(): ?int
    {
        return $this->idVis;
    }

    public function setIdVis(?int $idVis): void
    {
        $this->idVis = $idVis;
    }


}