<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\ContingentDocumentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContingentDocumentTypeRepository::class)]
class ContingentDocumentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: ContingentDocument::class)]
    private Collection $contingentDocuments;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Title = null;

    public function __construct()
    {
        $this->contingentDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ContingentDocument>
     */
    public function getContingentDocuments(): Collection
    {
        return $this->contingentDocuments;
    }

    public function addContingentDocument(ContingentDocument $contingentDocument): self
    {
        if (!$this->contingentDocuments->contains($contingentDocument)) {
            $this->contingentDocuments->add($contingentDocument);
            $contingentDocument->setType($this);
        }

        return $this;
    }

    public function removeContingentDocument(ContingentDocument $contingentDocument): self
    {
        if ($this->contingentDocuments->removeElement($contingentDocument)) {
            // set the owning side to null (unless already changed)
            if ($contingentDocument->getType() === $this) {
                $contingentDocument->setType(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
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
