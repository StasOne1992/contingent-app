<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\CollegeRepository;
use App\mod_mosregvis\Entity\MosregVISCollege;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollegeRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
class College
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $shortName = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $postalAddress = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $registeredAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $webSite = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $logo = null;

    #[ORM\Column(length: 13)]
    private ?string $phone = null;

    #[ORM\Column(length: 13)]
    private ?string $fax = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $SettingsStaffDomain = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $SettingsStudentsDomain = null;

    #[ORM\OneToMany(mappedBy: 'College', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'College', targetEntity: Admission::class)]
    private Collection $admissions;

    #[ORM\ManyToMany(targetEntity: Staff::class, mappedBy: 'College')]
    private Collection $staff;

    #[ORM\OneToMany(mappedBy: 'College', targetEntity: StudentGroups::class)]
    private Collection $studentGroups;


    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->admissions = new ArrayCollection();
        $this->staff = new ArrayCollection();
        $this->studentGroups = new ArrayCollection();

    }

    public function getFullName(): ?string
    {
        return $this->getname();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getname(): ?string
    {
        return $this->name;
    }

    public function setname(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): self
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getPostalAddress(): ?string
    {
        return $this->postalAddress;
    }

    public function setPostalAddress(string $postalAddress): self
    {
        $this->postalAddress = $postalAddress;

        return $this;
    }

    public function getregisteredAddress(): ?string
    {
        return $this->registeredAddress;
    }

    public function setregisteredAddress(string $registeredAddress): self
    {
        $this->registeredAddress = $registeredAddress;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getWebSite(): ?string
    {
        return $this->webSite;
    }

    public function setWebSite(string $webSite): self
    {
        $this->webSite = $webSite;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }
    public function __toString(): string
    {
     return $this->getShortName();
    }

    public function getSettingsStaffDomain(): ?string
    {
        return $this->SettingsStaffDomain;
    }

    public function setSettingsStaffDomain(?string $SettingsStaffDomain): static
    {
        $this->SettingsStaffDomain = $SettingsStaffDomain;

        return $this;
    }

    public function getSettingsStudentsDomain(): ?string
    {
        return $this->SettingsStudentsDomain;
    }

    public function setSettingsStudentsDomain(?string $SettingsStudentsDomain): static
    {
        $this->SettingsStudentsDomain = $SettingsStudentsDomain;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setCollege($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCollege() === $this) {
                $user->setCollege(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Admission>
     */
    public function getAdmissions(): Collection
    {
        return $this->admissions;
    }

    public function addAdmission(Admission $admission): static
    {
        if (!$this->admissions->contains($admission)) {
            $this->admissions->add($admission);
            $admission->setCollege($this);
        }

        return $this;
    }

    public function removeAdmission(Admission $admission): static
    {
        if ($this->admissions->removeElement($admission)) {
            // set the owning side to null (unless already changed)
            if ($admission->getCollege() === $this) {
                $admission->setCollege(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getStaff(): Collection
    {
        return $this->staff;
    }

    public function addStaff(Staff $staff): static
    {
        if (!$this->staff->contains($staff)) {
            $this->staff->add($staff);
            $staff->addCollege($this);
        }

        return $this;
    }

    public function removeStaff(Staff $staff): static
    {
        if ($this->staff->removeElement($staff)) {
            $staff->removeCollege($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, StudentGroups>
     */
    public function getStudentGroups(): Collection
    {
        return $this->studentGroups;
    }

    public function addStudentGroup(StudentGroups $studentGroup): static
    {
        if (!$this->studentGroups->contains($studentGroup)) {
            $this->studentGroups->add($studentGroup);
            $studentGroup->setCollege($this);
        }

        return $this;
    }

    public function removeStudentGroup(StudentGroups $studentGroup): static
    {
        if ($this->studentGroups->removeElement($studentGroup)) {
            // set the owning side to null (unless already changed)
            if ($studentGroup->getCollege() === $this) {
                $studentGroup->setCollege(null);
            }
        }

        return $this;
    }

    public function getActiveAdmission(): ?Admission
    {
        foreach ($this->getAdmissions() as $item) {
            if ($item->isIsActive()) {
                return $item;
            }
        }
        return null;
    }


}
