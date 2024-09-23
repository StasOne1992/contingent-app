<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\PersonalDocTypeListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalDocTypeListRepository::class)]
class PersonalDocTypeList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'DocumentType', targetEntity: PersonalDocuments::class)]
    private Collection $personalDocuments;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    public function __construct()
    {
        $this->personalDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, PersonalDocuments>
     */
    public function getPersonalDocuments(): Collection
    {
        $this->getPersonalDocuments()->getValues();
        return $this->personalDocuments;
    }

    public function addPersonalDocument(PersonalDocuments $personalDocument): self
    {
        if (!$this->personalDocuments->contains($personalDocument)) {
            $this->personalDocuments->add($personalDocument);
            $personalDocument->setDocumentType($this);
        }

        return $this;
    }

    public function removePersonalDocument(PersonalDocuments $personalDocument): self
    {
        if ($this->personalDocuments->removeElement($personalDocument)) {
            // set the owning side to null (unless already changed)
            if ($personalDocument->getDocumentType() === $this) {
                $personalDocument->setDocumentType(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return (string) $this->getName();
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(?string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

}
