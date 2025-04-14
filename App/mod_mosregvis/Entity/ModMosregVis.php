<?php

namespace App\mod_mosregvis\Entity;

use App\MainApp\Entity\College;
use App\mod_mosregvis\Repository\modMosregVisRepository;
use App\mod_mosregvis\Entity\MosregVISCollege;
use Doctrine\ORM\Mapping as ORM;
use FontLib\Table\Type\name;

#[ORM\Entity(repositoryClass: modMosregVisRepository::class)]
class ModMosregVis
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string|null $username = null;

    #[ORM\Column(length: 255)]
    private string|null $password = null;

    #[ORM\Column(length: 255,nullable: true)]
    private string|null $orgId = null;
    #[ORM\ManyToOne(inversedBy: 'MosregVISCollege')]
    private MosregVISCollege|null $mosregVISCollege = null;

    #[ORM\ManyToOne(inversedBy: 'College')]
    private College|null $college = null;

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
        $this->password = $password;

        return $this;
    }
    public function __toString(): string
    {
        return $this->username;
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

    public function getMosregVISCollege(): ?\App\mod_mosregvis\Entity\MosregVISCollege
    {
        return $this->mosregVISCollege;
    }

    public function setMosregVISCollege(?\App\mod_mosregvis\Entity\MosregVISCollege $mosregVISCollege): void
    {
        $this->mosregVISCollege = $mosregVISCollege;
    }
}
