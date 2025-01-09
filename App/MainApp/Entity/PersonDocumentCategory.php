<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\PersonDocumentCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonDocumentCategoryRepository::class)]
class PersonDocumentCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column()]
    private ?int $id = null;
    #[ORM\Column()]
    private ?string $name = null;
    #[ORM\Column()]
    private ?string $title = null;
    #[ORM\OneToMany(mappedBy: 'documentCategory', targetEntity: 'PersonDocument')]
    private Collection $personDocuments;


    public function __construct()
    {
        $this->personDocuments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    public function getPersonDocuments(): Collection
    {
        return $this->personDocuments;
    }

    public function setPersonDocuments(Collection $personDocuments): void
    {
        $this->personDocuments = $personDocuments;
    }


}