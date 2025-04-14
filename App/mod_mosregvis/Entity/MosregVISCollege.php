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
class MosregVISCollege
{
    #[ORM\Id, ORM\GeneratedValue(strategy: 'SEQUENCE'), ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: College::class)]
    private College|null $college;

    #[ORM\OneToMany(mappedBy: 'mosregVISCollege', targetEntity: modMosregVis::class)]
    private Collection $modMosregVis;


    #[ORM\Column(nullable: true)]
    private ?string $visCollegeId = '';

    public function __construct()
    {
        $this->modMosregVis = new ArrayCollection();
    }


    /**
     * @return Collection<int, modMosregVis>
     */
    public function getModMosregVIS(): Collection
    {
        return $this->modMosregVis;
    }

    public function addModMosregVIS(modMosregVis $modMosregVis): static
    {

        if (!$this->modMosregVis->contains($modMosregVis)) {
            $this->modMosregVis->add($modMosregVis);
            $modMosregVis->setCollege($this);
        }
        return $this;
    }

    public function removeModMosregVIS(modMosregVis $modMosregVis): static
    {
        //TODO: make this method
        return $this;
    }

    public function __toString(): string
    {
        return $this->visCollegeId;
    }

    public function getVisCollegeId(): ?string
    {
        return $this->visCollegeId;
    }

    public function setVisCollegeId(?string $visCollegeId): void
    {
        $this->visCollegeId = $visCollegeId;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): void
    {
        $this->college = $college;
    }
}