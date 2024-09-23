<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\StaffRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StaffRepository::class)]
class Staff
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'Staff', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column(length: 255)]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255)]
    private ?string $LastName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $MiddleName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Photo = null;

    #[ORM\OneToMany(mappedBy: 'GroupLeader', targetEntity: StudentGroups::class)]
    private Collection $studentGroups;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $UUID = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: EventsList::class, mappedBy: 'EventResponsible')]
    private Collection $eventsLists;

    #[ORM\ManyToMany(targetEntity: College::class, inversedBy: 'staff')]
    private Collection $College;

    #[ORM\ManyToOne(inversedBy: 'staff')]
    private ?Person $person = null;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->studentGroups = new ArrayCollection();
        $this->eventsLists = new ArrayCollection();
        $this->College = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setStaff($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getStaff() === $this) {
                $user->setStaff(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getFirstName()." ".$this->getMiddleName()." ".$this->getLastName();
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(string $FirstName): self
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->MiddleName;
    }

    public function setMiddleName(?string $MiddleName): self
    {
        $this->MiddleName = $MiddleName;

        return $this;
    }


    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(?string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }

    /**
     * @return Collection<int, StudentGroups>
     */
    public function getStudentGroups(): Collection
    {
        return $this->studentGroups;
    }

    public function addStudentGroup(StudentGroups $studentGroup): self
    {
        if (!$this->studentGroups->contains($studentGroup)) {
            $this->studentGroups->add($studentGroup);
            $studentGroup->setGroupLeader($this);
        }

        return $this;
    }

    public function removeStudentGroup(StudentGroups $studentGroup): self
    {
        if ($this->studentGroups->removeElement($studentGroup)) {
            // set the owning side to null (unless already changed)
            if ($studentGroup->getGroupLeader() === $this) {
                $studentGroup->setGroupLeader(null);
            }
        }

        return $this;
    }

    public function getUUID(): ?string
    {
        return $this->UUID;
    }

    public function setUUID(?string $UUID): static
    {
        $this->UUID = $UUID;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, EventsList>
     */
    public function getEventsLists(): Collection
    {
        return $this->eventsLists;
    }

    public function addEventsList(EventsList $eventsList): static
    {
        if (!$this->eventsLists->contains($eventsList)) {
            $this->eventsLists->add($eventsList);
            $eventsList->addEventResponsible($this);
        }

        return $this;
    }

    public function removeEventsList(EventsList $eventsList): static
    {
        if ($this->eventsLists->removeElement($eventsList)) {
            $eventsList->removeEventResponsible($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, College>
     */
    public function getCollege(): Collection
    {
        return $this->College;
    }

    public function addCollege(College $college): static
    {
        if (!$this->College->contains($college)) {
            $this->College->add($college);
        }

        return $this;
    }

    public function removeCollege(College $college): static
    {
        $this->College->removeElement($college);

        return $this;
    }


    public function getStudentList(): array
    {
        $result= array();
        /***
         * @var StudentGroups $studentGroup
         */
        $studentGroups=$this->getStudentGroups()->getValues();
        foreach ($studentGroups as $group)
        {
            $result=array_merge($result,$group->getStudents()->getValues());
        }
        return $result;

    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): static
    {
        $this->person = $person;

        return $this;
    }

}
