<?php

namespace App\mod_mosregvis\Entity;

use App\mod_mosregvis\Repository\modMosregVisRepository;
use App\mod_mosregvis\Entity\MosregVISCollege;
use Doctrine\ORM\Mapping as ORM;
use FontLib\Table\Type\name;

#[ORM\Entity(repositoryClass: modMosregVisRepository::class)]
class ModMosregVis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 255,nullable: true)]
    private ?string $orgId = null;
    #[ORM\ManyToOne(inversedBy: 'MosregVISCollege')]
    private ?MosregVISCollege $mosregVISCollege = null;


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
    public function setMosregVISCollege(MosregVISCollege $mosregVISCollege):static
    {
        $this->mosregVISCollege=$mosregVISCollege;
        return $this;
    }
    public function getMosregVISCollege():?MosregVISCollege
    {
        return $this->mosregVISCollege;
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
}
