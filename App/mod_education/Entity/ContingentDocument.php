<?php

namespace App\mod_education\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\MainApp\Entity\College;
use App\mod_education\Controller\Api\ContingentDocument\PushGroupMemberShip;
use App\mod_education\Repository\ContingentDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Attribute\Groups;
use ApiPlatform\Metadata\Post;

#[ORM\Entity(repositoryClass: ContingentDocumentRepository::class)]

#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'contingent_document:item'],name: 'getDocument'),
        new GetCollection(normalizationContext: ['groups' => 'contingent_document:list']),
    ],
)]
class ContingentDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column]
    #[Groups(['contingent_document:list', 'contingent_document:item','contingent_document_students:item'])]
    private ?int $id = null;
    #[ORM\Column(length: 255)]
    #[Groups(['contingent_document:list', 'contingent_document:item'])]
    private ?string $number = null;
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['contingent_document:list', 'contingent_document:item'])]
    private ?\DateTimeInterface $createDate = null;
    #[ORM\ManyToOne(inversedBy: 'contingentDocuments')]
    private ?ContingentDocumentType $type = null;
    #[ORM\Column]
    private ?bool $isActive = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;
    #[ORM\ManyToOne(inversedBy: 'contingentDocuments')]
    private ?College $College = null;
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Reason = null;
    #[ORM\OneToMany(mappedBy: 'ContingentDocument', targetEntity: GroupMembership::class)]
    #[Groups(['contingent_document:item'])]
    private Collection $GroupMemberships;

    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->GroupMemberships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getCreateDate(): ?\DateTimeInterface
    {
        return $this->createDate;
    }

    public function setCreateDate(\DateTimeInterface $createDate): self
    {
        $this->createDate = $createDate;

        return $this;
    }

    public function getType(): ?ContingentDocumentType
    {
        return $this->type;
    }

    public function setType(?ContingentDocumentType $type): self
    {
        $this->type = $type;

        return $this;
    }

     public function isIsActive(): ?bool
     {
         return $this->isActive;
     }

     public function setIsActive(bool $isActive): self
     {
         $this->isActive = $isActive;

         return $this;
     }

     public function getName(): ?string
     {
         return $this->name;
     }

     public function setName(?string $name): self
     {
         $this->name = $name;

         return $this;
     }

     public function getCollege(): ?College
     {
         return $this->College;
     }

     public function setCollege(?College $College): self
     {
         $this->College = $College;

         return $this;
     }

     public function getReason(): ?string
     {
         return $this->Reason;
     }

     public function setReason(string $Reason): self
     {
         $this->Reason = $Reason;

         return $this;
     }

     public function __toString(): string
     {
         return $this->getType().' № '.$this->getNumber().' от '.$this->getCreateDate()->format('d.m.Y');
     }

     /**
      * @return Collection<int, GroupMembership>
      */
    public function getGroupMemberships(): Collection
    {
        return $this->GroupMemberships;
    }

    public function addGroupMembership(GroupMembership $GroupMembership): static
    {
        if (!$this->GroupMemberships->contains($GroupMembership)) {
            $this->GroupMemberships->add($GroupMembership);
            $GroupMembership->setContingentDocument($this);
        }

        return $this;
    }

    public function removeGroupMembership(GroupMembership $GroupMembership): static
    {
        if ($this->GroupMemberships->removeElement($GroupMembership)) {
            // set the owning side to null (unless already changed)
            if ($GroupMembership->getContingentDocument() === $this) {
                $GroupMembership->setContingentDocument(null);
            }
        }

        return $this;
    }
}

