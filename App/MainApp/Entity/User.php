<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Student $Student = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Staff $Staff = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsStudent = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $userphoto = null;

    #[ORM\Column(nullable: true)]
    private ?array $FrontEndParams = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?College $College = null;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getStudentProfileID(): int
    {
        $StudentRole = in_array("ROLE_STUDENT", array_unique($this->roles));


        if (!(is_Null($this->getStudent())) && ($StudentRole)) {
            $result = $this->getStudent()->getId();
            return $result;
        }
        return (0);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function removeRole(Roles $role): self
    {
        $this->Role->removeElement($role);

        return $this;
    }

    public function getStudent(): ?Student
    {
        /*if (isNull($this->Student->getStudentGroup()))
        {
            $group = new StudentGroups();
            $group->setName("Группа не указана");
            $group->setCode("EMPTY");
            $group->setLetter("EMP");
            $this->Student->setStudentGroup($group);
        }*/

        return $this->Student;
    }

    public function setStudent(?Student $Student): self
    {
        $this->Student = $Student;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->Staff;
    }


    public function setStaff(?Staff $Staff): self
    {
        $this->Staff = $Staff;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getStudentProfileID();
    }

    public function isIsStudent(): ?bool
    {
        return $this->IsStudent;
    }

    public function setIsStudent(?bool $IsStudent=true): self
    {
        $this->IsStudent = $IsStudent;

        return $this;
    }

    public function getUserphoto(): ?string
    {
        return $this->userphoto;
    }

    public function setUserphoto(?string $userphoto): self
    {
        $this->userphoto = $userphoto;

        return $this;
    }

    public function getFrontEndParams(): ?array
    {
        return $this->FrontEndParams;
    }

    public function setFrontEndParams(?array $FrontEndParams): static
    {
        $this->FrontEndParams = $FrontEndParams;

        return $this;
    }

    public function getCollege(): ?College
    {
        return $this->College;
    }

    public function setCollege(?College $College): static
    {
        $this->College = $College;

        return $this;
    }
}
