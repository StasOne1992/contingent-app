<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\LoginValuesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoginValuesRepository::class)]
class LoginValues
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'loginValues')]
    private ?Student $Student = null;

    #[ORM\Column(length: 255)]
    private ?string $LoginValue = null;

    #[ORM\Column(length: 255)]
    private ?string $PasswordValue = null;

    #[ORM\ManyToOne(inversedBy: 'loginValues')]
    private ?LoginProvider $LoginProvider = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->Student;
    }

    public function setStudent(?Student $Student): static
    {
        $this->Student = $Student;

        return $this;
    }

    public function getLoginValue(): ?string
    {
        return $this->LoginValue;
    }

    public function setLoginValue(string $LoginValue): static
    {
        $this->LoginValue = $LoginValue;

        return $this;
    }

    public function getPasswordValue(): ?string
    {
        return $this->PasswordValue;
    }

    public function setPasswordValue(string $PasswordValue): static
    {
        $this->PasswordValue = $PasswordValue;

        return $this;
    }

    public function getLoginProvider(): ?LoginProvider
    {
        return $this->LoginProvider;
    }

    public function setLoginProvider(?LoginProvider $LoginProvider): static
    {
        $this->LoginProvider = $LoginProvider;

        return $this;
    }
}
