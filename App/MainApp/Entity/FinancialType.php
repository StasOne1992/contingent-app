<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\FinancialTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FinancialTypeRepository::class)]
class FinancialType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'financialType', targetEntity: Faculty::class)]
    private Collection $faculties;

    public function __construct()
    {
        $this->faculties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, Faculty>
     */
    public function getFaculties(): Collection
    {
        return $this->faculties;
    }

    public function addFaculty(Faculty $faculty): static
    {
        if (!$this->faculties->contains($faculty)) {
            $this->faculties->add($faculty);
            $faculty->setFinancialType($this);
        }

        return $this;
    }

    public function removeFaculty(Faculty $faculty): static
    {
        if ($this->faculties->removeElement($faculty)) {
            // set the owning side to null (unless already changed)
            if ($faculty->getFinancialType() === $this) {
                $faculty->setFinancialType(null);
            }
        }

        return $this;
    }
}
