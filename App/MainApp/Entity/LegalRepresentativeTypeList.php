<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\LegalRepresentativeTypeListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LegalRepresentativeTypeListRepository::class)]
class LegalRepresentativeTypeList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'RepresentativesType', targetEntity: LegalRepresentative::class)]
    private Collection $legalRepresentatives;

    public function __construct()
    {
        $this->legalRepresentatives = new ArrayCollection();
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
     * @return Collection<int, LegalRepresentative>
     */
    public function getLegalRepresentatives(): Collection
    {
        return $this->legalRepresentatives;
    }

    public function addLegalRepresentative(LegalRepresentative $legalRepresentative): self
    {
        if (!$this->legalRepresentatives->contains($legalRepresentative)) {
            $this->legalRepresentatives->add($legalRepresentative);
            $legalRepresentative->setRepresentativesType($this);
        }

        return $this;
    }

    public function removeLegalRepresentative(LegalRepresentative $legalRepresentative): self
    {
        if ($this->legalRepresentatives->removeElement($legalRepresentative)) {
            // set the owning side to null (unless already changed)
            if ($legalRepresentative->getRepresentativesType() === $this) {
                $legalRepresentative->setRepresentativesType(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }
}
