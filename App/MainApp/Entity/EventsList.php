<?php

namespace App\MainApp\Entity;

use App\MainApp\Repository\EventsListRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: EventsListRepository::class)]
class EventsList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Name = null;

    #[ORM\ManyToOne(inversedBy: 'eventsLists')]
    private ?EventsCategory $EventCategory = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $EventDate = null;

    #[ORM\Column]
    private ?bool $IsGroupEvent = null;

    #[ORM\ManyToOne(inversedBy: 'eventsLists')]
    private ?EventsLevel $EventLevel = null;

    #[ORM\ManyToOne(inversedBy: 'eventsLists')]
    private ?EventsPlaces $EventPlace = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $EventStartTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $EventEndTime = null;

    #[ORM\ManyToMany(targetEntity: Staff::class, inversedBy: 'eventsLists')]
    private Collection $EventResponsible;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $Comment = null;

    #[ORM\Column]
    private ?bool $IsPublic = null;

    #[ORM\ManyToMany(targetEntity: Student::class, inversedBy: 'eventsLists')]
    private Collection $EventParticipant;

    #[ORM\Column (nullable: true)]
    private ?bool $IsCanHaveResults = null;

    #[ORM\Column(nullable: true)]
    private ?bool $IsArchived = null;

    #[ORM\OneToMany(mappedBy: 'Event', targetEntity: EventsResult::class)]
    private Collection $eventsResults;


    public function __construct()
    {
        $this->EventResponsible = new ArrayCollection();
        $this->EventParticipant = new ArrayCollection();
        $this->eventsResults = new ArrayCollection();
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

    public function getEventCategory(): ?EventsCategory
    {
        return $this->EventCategory;
    }

    public function setEventCategory(?EventsCategory $EventCategory): static
    {
        $this->EventCategory = $EventCategory;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->EventDate;
    }

    public function setEventDate(\DateTimeInterface $EventDate): static
    {
        $this->EventDate = $EventDate;

        return $this;
    }

    public function isIsGroupEvent(): ?bool
    {
        return $this->IsGroupEvent;
    }

    public function setIsGroupEvent(bool $IsGroupEvent): static
    {
        $this->IsGroupEvent = $IsGroupEvent;

        return $this;
    }

    public function getEventLevel(): ?EventsLevel
    {
        return $this->EventLevel;
    }

    public function setEventLevel(?EventsLevel $EventLevel): static
    {
        $this->EventLevel = $EventLevel;

        return $this;
    }

    public function getEventPlace(): ?EventsPlaces
    {
        return $this->EventPlace;
    }

    public function setEventPlace(?EventsPlaces $EventPlace): static
    {
        $this->EventPlace = $EventPlace;

        return $this;
    }

    public function getEventStartTime(): ?\DateTimeInterface
    {
        return $this->EventStartTime;
    }

    public function setEventStartTime(\DateTimeInterface $EventStartTime): static
    {
        $this->EventStartTime = $EventStartTime;

        return $this;
    }

    public function getEventEndTime(): ?\DateTimeInterface
    {
        return $this->EventEndTime;
    }

    public function setEventEndTime(\DateTimeInterface $EventEndTime): static
    {
        $this->EventEndTime = $EventEndTime;

        return $this;
    }

    /**
     * @return Collection<int, Staff>
     */
    public function getEventResponsible(): Collection
    {
        return $this->EventResponsible;
    }

    public function addEventResponsible(Staff $eventResponsible): static
    {
        if (!$this->EventResponsible->contains($eventResponsible)) {
            $this->EventResponsible->add($eventResponsible);
        }

        return $this;
    }

    public function removeEventResponsible(Staff $eventResponsible): static
    {
        $this->EventResponsible->removeElement($eventResponsible);

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->Comment;
    }

    public function setComment(?string $Comment): static
    {
        $this->Comment = $Comment;

        return $this;
    }

    public function isIsPublic(): ?bool
    {
        return $this->IsPublic;
    }

    public function setIsPublic(bool $IsPublic): static
    {
        $this->IsPublic = $IsPublic;

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getEventParticipant(): Collection
    {
        return $this->EventParticipant;
    }

    public function addEventParticipant(Student $eventParticipant): static
    {
        if (!$this->EventParticipant->contains($eventParticipant)) {
            $this->EventParticipant->add($eventParticipant);
        }

        return $this;
    }

    public function removeEventParticipant(Student $eventParticipant): static
    {
        $this->EventParticipant->removeElement($eventParticipant);

        return $this;
    }

    public function isCanHaveResult(): ?bool
    {
        return $this->CanHaveResult;
    }

    public function setCanHaveResult(bool $CanHaveResult): static
    {
        $this->CanHaveResult = $CanHaveResult;

        return $this;
    }

    public function isIsCanHaveResults(): ?bool
    {
        return $this->IsCanHaveResults;
    }

    public function setIsCanHaveResults(bool $IsCanHaveResults): static
    {
        $this->IsCanHaveResults = $IsCanHaveResults;

        return $this;
    }

    public function isIsArchived(): ?bool
    {
        return $this->IsArchived;
    }

    public function setIsArchived(?bool $IsArchived): static
    {
        $this->IsArchived = $IsArchived;

        return $this;
    }

    /**
     * @return Collection<int, EventsResult>
     */
    public function getEventsResults(): Collection
    {
        return $this->eventsResults;
    }

    public function addEventsResult(EventsResult $eventsResult): static
    {
        if (!$this->eventsResults->contains($eventsResult)) {
            $this->eventsResults->add($eventsResult);
            $eventsResult->setEvent($this);
        }

        return $this;
    }

    public function removeEventsResult(EventsResult $eventsResult): static
    {
        if ($this->eventsResults->removeElement($eventsResult)) {
            // set the owning side to null (unless already changed)
            if ($eventsResult->getEvent() === $this) {
                $eventsResult->setEvent(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
