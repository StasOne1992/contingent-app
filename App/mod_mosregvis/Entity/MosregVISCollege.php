<?php

namespace App\mod_mosregvis\Entity;

use App\MainApp\Entity\College;
use App\mod_mosregvis\Entity\reference_SpoEducationYear;
use App\MainApp\Repository\CollegeRepository;
use App\mod_mosregvis\Repository\MosregVISCollegeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MosregVISCollegeRepository::class)]
class MosregVISCollege extends College
{
    #[ORM\OneToMany(mappedBy: 'mosregVISCollege', targetEntity: modMosregVis::class)]
    private Collection $modmosregvis;

    #[ORM\OneToMany(mappedBy: 'college', targetEntity: MosregVISCollege::class)]
    private Collection $spoEducationYear;

    #[ORM\Column(nullable: true)]
    private ?string $visCollegeId = '';

    public function __construct()
    {
        parent::__construct();
        $this->modmosregvis = new ArrayCollection();
        $this->spoEducationYear = new ArrayCollection();
    }


    /**
     * @return Collection<int, modMosregVis>
     */
    public function getModMosregVIS(): Collection
    {
        return $this->modmosregvis;
    }

    public function addModMosregVIS(modMosregVis $modmosregvis): static
    {

        if (!$this->modmosregvis->contains($modmosregvis)) {
            $this->modmosregvis->add($modmosregvis);
            $modmosregvis->setCollege($this);
        }
        return $this;
    }
    public function removeModMosregVIS(modMosregVis $modmosregvis): static
    {
        //TODO: make this method
        return $this;
    }
    public function __toString(): string
    {
        return parent::__toString();
    }

    public function getSpoEducationYear(): Collection
    {
        return $this->spoEducationYear;
    }

    public function addSpoEducationYear(reference_SpoEducationYear $spoEducationYear): static
    {
        if (!$this->spoEducationYear->contains($spoEducationYear)) {
            $this->spoEducationYear->add($spoEducationYear);
            $spoEducationYear->setCollege($this);
        }
        return $this;
    }

    public function getVisCollegeId(): ?string
    {
        return $this->visCollegeId;
    }

    public function setVisCollegeId(?string $visCollegeId): void
    {
        $this->visCollegeId = $visCollegeId;
    }

}