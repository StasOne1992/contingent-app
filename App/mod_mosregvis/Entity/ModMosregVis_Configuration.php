<?php

namespace App\mod_mosregvis\Entity;

use App\MainApp\Entity\College;
use App\MainApp\Entity\User;
use App\mod_mosregvis\Repository\modMosregVis_ConfigurationRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
#[ORM\Entity(repositoryClass: modMosregVis_ConfigurationRepository::class)]
class ModMosregVis_Configuration
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string|null $username = null;

    #[ORM\Column(length: 255)]
    private string|null $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string|null $orgId = null;
    #[ORM\ManyToOne(targetEntity: ModMosregVis_College::class, inversedBy: 'modMosregVis')]
    private ModMosregVis_College|null $mosregVISCollege = null;
    #[ORM\ManyToOne(targetEntity: College::class, inversedBy: 'modMosregVis')]
    private College|null $college = null;

    #[ORM\OneToMany(targetEntity: User::class, mappedBy: "modMosregVis_Configuration")]
    private Collection $users;

    public function __construct()
    {
        $this->users=new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $stringToHash = "{$this->getUsername()}:{$password}";
        $hash = hash(algo: "sha256", data: $stringToHash);
        $this->password = $hash;
        return $this;
    }

    public function __toString(): string
    {
        return "{$this->username} - {$this->mosregVISCollege->getInn()}";
    }

    public function getOrgId(): ?string
    {
        return $this->orgId;
    }

    public function setOrgId(?string $orgId): void
    {
        $this->orgId = $orgId;
    }

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): void
    {
        $this->college = $college;
    }

    public function getMosregVISCollege(): ?ModMosregVis_College
    {
        return $this->mosregVISCollege;
    }

    public function setMosregVISCollege(?ModMosregVis_College $mosregVISCollege): void
    {
        $this->mosregVISCollege = $mosregVISCollege;
    }



}
