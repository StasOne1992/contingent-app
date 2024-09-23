<?php

namespace App\mod_mosregvis\Entity;

use App\mod_mosregvis\Repository\reference_studyDisciplineRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Boolean;


#[ORM\Entity(repositoryClass: reference_studyDisciplineRepository::class)]
class reference_studyDiscipline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idVis = null;

    #[ORM\Column]
    private string $name;

    #[ORM\Column(nullable: true)]
    private ?string $disciplineGroup = null;

    #[ORM\Column]
    private bool $isSpo = false;
    #[ORM\Column]
    private bool $isSchool = false;
    #[ORM\Column]
    private bool $isOdo = false;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int|null
     */
    public function getIdVis(): ?int
    {
        return $this->idVis;
    }

    /**
     * @param int|null $idVis
     */
    public function setIdVis(?int $idVis): void
    {
        $this->idVis = $idVis;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDisciplineGroup(): ?string
    {
        return $this->disciplineGroup;
    }

    /**
     * @param string|null $disciplineGroup
     */
    public function setDisciplineGroup(?string $disciplineGroup): void
    {
        $this->disciplineGroup = $disciplineGroup;
    }

    /**
     * @return bool
     */
    public function isSpo(): bool
    {
        return $this->isSpo;
    }

    /**
     * @param bool $isSpo
     */
    public function setIsSpo(bool $isSpo): void
    {
        $this->isSpo = $isSpo;
    }

    /**
     * @return bool
     */
    public function isSchool(): bool
    {
        return $this->isSchool;
    }

    /**
     * @param bool $isSchool
     */
    public function setIsSchool(bool $isSchool): void
    {
        $this->isSchool = $isSchool;
    }

    /**
     * @return bool
     */
    public function isOdo(): bool
    {
        return $this->isOdo;
    }

    /**
     * @param bool $isOdo
     */
    public function setIsOdo(bool $isOdo): void
    {
        $this->isOdo = $isOdo;
    }


}