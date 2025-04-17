<?php

namespace App\mod_mosregvis\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\MainApp\Entity\College;
use App\mod_mosregvis\Entity\reference_SpoEducationYear;
use App\MainApp\Repository\CollegeRepository;
use App\mod_mosregvis\Repository\MosregVISCollegeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MosregVISCollegeRepository::class)]
#[ApiResource]
class MosregVISCollege
{
    #[ORM\Id, ORM\GeneratedValue(strategy: 'SEQUENCE'), ORM\Column]
    private int|null $id = null;

    #[ORM\OneToOne(targetEntity: College::class)]
    private College|null $college;

    #[ORM\OneToMany(targetEntity: ModMosregVis::class, mappedBy: 'mosregVISCollege')]
    private Collection $modMosregVis;
    #[ORM\OneToMany(targetEntity: reference_SpoEducationYear::class, mappedBy: 'college')]
    private Collection $referenceSpoEducationYear;

    #[ORM\Column(nullable: true)]
    private string|null $guid = '';
    #[ORM\Column(nullable: true)]
    private string|null $fullName = '';
    #[ORM\Column(nullable: true)]
    private string|null $headPerson = '';
    #[ORM\Column(nullable: true)]
    private string|null $inn = '';
    #[ORM\Column(nullable: true)]
    private string|null $email = '';
    #[ORM\Column(nullable: true)]
    private string|null $phone = '';
    #[ORM\Column(nullable: true)]
    private string|null $website = '';
    #[ORM\Column(nullable: true)]
    private string|null $secretary = '';
    #[ORM\Column(nullable: true)]
    private bool $isSpo = false;
    #[ORM\Column(nullable: true)]
    private bool $isSchool = false;
    #[ORM\Column(nullable: true)]
    private bool $isOdo = false;
    #[ORM\Column(nullable: true)]
    private string|null $kpp = '';
    #[ORM\Column(nullable: true)]
    private string|null $ogrn = '';
    #[ORM\Column(nullable: true)]
    private string|null $okpo = '';





    public function __construct()
    {
        $this->modMosregVis = new ArrayCollection();
        $this->referenceSpoEducationYear = new ArrayCollection();
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

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function setGuid(?string $guid): void
    {
        $this->guid = $guid;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    public function getOkpo(): ?string
    {
        return $this->okpo;
    }

    public function setOkpo(?string $okpo): void
    {
        $this->okpo = $okpo;
    }

    public function getOgrn(): ?string
    {
        return $this->ogrn;
    }

    public function setOgrn(?string $ogrn): void
    {
        $this->ogrn = $ogrn;
    }

    public function getKpp(): ?string
    {
        return $this->kpp;
    }

    public function setKpp(?string $kpp): void
    {
        $this->kpp = $kpp;
    }

    public function isOdo(): bool
    {
        return $this->isOdo;
    }

    public function setIsOdo(bool $isOdo): void
    {
        $this->isOdo = $isOdo;
    }

    public function getHeadPerson(): ?string
    {
        return $this->headPerson;
    }

    public function setHeadPerson(?string $headPerson): void
    {
        $this->headPerson = $headPerson;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getInn(): ?string
    {
        return $this->inn;
    }

    public function setInn(?string $inn): void
    {
        $this->inn = $inn;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function getSecretary(): ?string
    {
        return $this->secretary;
    }

    public function setSecretary(?string $secretary): void
    {
        $this->secretary = $secretary;
    }

    public function isSpo(): bool
    {
        return $this->isSpo;
    }

    public function setIsSpo(bool $isSpo): void
    {
        $this->isSpo = $isSpo;
    }

    public function isSchool(): bool
    {
        return $this->isSchool;
    }

    public function setIsSchool(bool $isSchool): void
    {
        $this->isSchool = $isSchool;
    }
}