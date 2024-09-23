<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\LoginProviderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoginProviderRepository::class)]
class LoginProvider
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\Column(length: 255)]
    private ?string $loginKey = null;

    #[ORM\Column(length: 255)]
    private ?string $PasswordKey = null;

    #[ORM\Column(length: 255)]
    private ?string $AuthPath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $CustomParams = null;

    #[ORM\OneToMany(mappedBy: 'LoginProvider', targetEntity: LoginValues::class)]
    private Collection $loginValues;

    #[ORM\Column(nullable: true)]
    private ?bool $UserCanLogin = null;

    public function __construct()
    {
        $this->loginValues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

        return $this;
    }

    public function getLoginKey(): ?string
    {
        return $this->loginKey;
    }

    public function setLoginKey(string $loginKey): static
    {
        $this->loginKey = $loginKey;

        return $this;
    }

    public function getPasswordKey(): ?string
    {
        return $this->PasswordKey;
    }

    public function setPasswordKey(string $PasswordKey): static
    {
        $this->PasswordKey = $PasswordKey;

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

    public function getAuthPath(): ?string
    {
        return $this->AuthPath;
    }

    public function setAuthPath(string $AuthPath): static
    {
        $this->AuthPath = $AuthPath;

        return $this;
    }

    public function getCustomParams(): ?string
    {
        return $this->CustomParams;
    }

    public function setCustomParams(?string $CustomParams): static
    {
        $this->CustomParams = $CustomParams;

        return $this;
    }

    /**
     * @return Collection<int, LoginValues>
     */
    public function getLoginValues(): Collection
    {
        return $this->loginValues;
    }

    public function addLoginValue(LoginValues $loginValue): static
    {
        if (!$this->loginValues->contains($loginValue)) {
            $this->loginValues->add($loginValue);
            $loginValue->setLoginProvider($this);
        }

        return $this;
    }

    public function removeLoginValue(LoginValues $loginValue): static
    {
        if ($this->loginValues->removeElement($loginValue)) {
            // set the owning side to null (unless already changed)
            if ($loginValue->getLoginProvider() === $this) {
                $loginValue->setLoginProvider(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTitle();
    }

    public function isUserCanLogin(): ?bool
    {
        return $this->UserCanLogin;
    }

    public function setUserCanLogin(bool $UserCanLogin): static
    {
        $this->UserCanLogin = $UserCanLogin;

        return $this;
    }
}
