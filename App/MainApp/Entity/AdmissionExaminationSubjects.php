<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\AdmissionExaminationSubjectsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdmissionExaminationSubjectsRepository::class)]
class AdmissionExaminationSubjects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'ExaminationSubject', targetEntity: AdmissionExamination::class)]
    private Collection $admissionExaminations;



    public function __construct()
    {
        $this->admissionExaminations = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, AdmissionExamination>
     */
    public function getAdmissionExaminations(): Collection
    {
        return $this->admissionExaminations;
    }

    public function addAdmissionExamination(AdmissionExamination $admissionExamination): static
    {
        if (!$this->admissionExaminations->contains($admissionExamination)) {
            $this->admissionExaminations->add($admissionExamination);
            $admissionExamination->setExaminationSubject($this);
        }

        return $this;
    }

    public function removeAdmissionExamination(AdmissionExamination $admissionExamination): static
    {
        if ($this->admissionExaminations->removeElement($admissionExamination)) {
            // set the owning side to null (unless already changed)
            if ($admissionExamination->getExaminationSubject() === $this) {
                $admissionExamination->setExaminationSubject(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
     return $this->getName();
    }

}
