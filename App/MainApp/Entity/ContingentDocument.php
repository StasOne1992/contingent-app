<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\ContingentDocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContingentDocumentRepository::class)]
class ContingentDocument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createDate = null;

    #[ORM\ManyToOne(inversedBy: 'contingentDocuments')]
    private ?ContingentDocumentType $type = null;

    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'contingentDocuments')]
    private Collection $student;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'contingentDocuments')]
    private ?College $College = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Reason = null;

    #[ORM\OneToMany(mappedBy: 'ContingentDocument', targetEntity: GroupMembership::class)]
    private Collection $groupMemberships;

    public function __construct()
    {
        $this->student = new ArrayCollection();
        $this->groupMemberships = new ArrayCollection();
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

    /**
     * @return Collection<int, Student>
     */
    public function getStudent(): Collection
    {
        return $this->student;
    }

    public function addStudent(Student $student): self
    {
        if (!$this->student->contains($student)) {
            $this->student->add($student);
        }

        return $this;
    }

    public function removeStudent(Student $student): self
    {
        $this->student->removeElement($student);

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
        return $this->groupMemberships;
    }

    public function addGroupMembership(GroupMembership $groupMembership): static
    {
        if (!$this->groupMemberships->contains($groupMembership)) {
            $this->groupMemberships->add($groupMembership);
            $groupMembership->setContingentDocument($this);
        }

        return $this;
    }

    public function removeGroupMembership(GroupMembership $groupMembership): static
    {
        if ($this->groupMemberships->removeElement($groupMembership)) {
            // set the owning side to null (unless already changed)
            if ($groupMembership->getContingentDocument() === $this) {
                $groupMembership->setContingentDocument(null);
            }
        }

        return $this;
    }
}
