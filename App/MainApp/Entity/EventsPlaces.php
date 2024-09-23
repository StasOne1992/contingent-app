<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\EventsPlacesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[ORM\Entity(repositoryClass: EventsPlacesRepository::class)]
class EventsPlaces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\OneToMany(mappedBy: 'EventPlace', targetEntity: EventsList::class)]
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
            $eventsList->setEventPlace($this);
        }

        return $this;
    }

    public function removeEventsList(EventsList $eventsList): static
    {
        if ($this->eventsLists->removeElement($eventsList)) {
            // set the owning side to null (unless already changed)
            if ($eventsList->getEventPlace() === $this) {
                $eventsList->setEventPlace(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->getName();
    }
}
