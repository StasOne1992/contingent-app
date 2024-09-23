<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\SocialNetworkRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SocialNetworkRepository::class)]
class SocialNetwork
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $SocialNetworkLink = null;

    #[ORM\ManyToOne(inversedBy: 'socialNetworks')]
    private ?Student $StudetnID = null;

    #[ORM\ManyToOne(inversedBy: 'socialNetworks')]
    private ?SocialNetworkTypeList $SocialNetworkTypeID = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialNetworkLink(): ?string
    {
        return $this->SocialNetworkLink;
    }

    public function setSocialNetworkLink(?string $SocialNetworkLink): self
    {
        $this->SocialNetworkLink = $SocialNetworkLink;

        return $this;
    }

    public function getStudetnID(): ?Student
    {
        return $this->StudetnID;
    }

    public function setStudetnID(?Student $StudetnID): self
    {
        $this->StudetnID = $StudetnID;

        return $this;
    }

    public function getSocialNetworkTypeID(): ?SocialNetworkTypeList
    {
        return $this->SocialNetworkTypeID;
    }

    public function setSocialNetworkTypeID(?SocialNetworkTypeList $SocialNetworkTypeID): self
    {
        $this->SocialNetworkTypeID = $SocialNetworkTypeID;

        return $this;
    }
}
