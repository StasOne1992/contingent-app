<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\EventsCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventsCategoryRepository::class)]
class EventsCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255)]
    private ?string $Title = null;

    #[ORM\OneToMany(mappedBy: 'EventCategory', targetEntity: EventsList::class)]
    private Collection $eventsLists;

    public function __construct()
    {
        $this->eventsLists = new ArrayCollection();
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

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): static
    {
        $this->Title = $Title;

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
            $eventsList->setEventCategory($this);
        }

        return $this;
    }

    public function removeEventsList(EventsList $eventsList): static
    {
        if ($this->eventsLists->removeElement($eventsList)) {
            // set the owning side to null (unless already changed)
            if ($eventsList->getEventCategory() === $this) {
                $eventsList->setEventCategory(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getTitle();
    }
}
