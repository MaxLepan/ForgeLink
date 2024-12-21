<?php

namespace App\Entity;

use App\Enum\TicketDeadline;
use App\Repository\FeedbackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Feedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $event_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $environmental_conditions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $operation_type = null;

    #[ORM\Column(length: 511)]
    private ?string $description = null;

    #[ORM\Column(enumType: TicketDeadline::class)]
    private ?TicketDeadline $deadline = null;

    #[ORM\Column(length: 511, nullable: true)]
    private ?string $suggested_solution = null;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $isNew = true;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, SuperTicket>
     */
    #[ORM\OneToMany(targetEntity: SuperTicket::class, mappedBy: 'parent_feedback')]
    private Collection $child_tickets;

    #[ORM\ManyToOne(inversedBy: 'feedbacks')]
    private ?Project $project = null;

    public function __construct()
    {
        $this->child_tickets = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getEventDate(): ?\DateTimeInterface
    {
        return $this->event_date;
    }

    public function setEventDate(\DateTimeInterface $event_date): static
    {
        $this->event_date = $event_date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getEnvironmentalConditions(): ?string
    {
        return $this->environmental_conditions;
    }

    public function setEnvironmentalConditions(?string $environmental_conditions): static
    {
        $this->environmental_conditions = $environmental_conditions;

        return $this;
    }

    public function getOperationType(): ?string
    {
        return $this->operation_type;
    }

    public function setOperationType(?string $operation_type): static
    {
        $this->operation_type = $operation_type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDeadline(): ?TicketDeadline
    {
        return $this->deadline;
    }

    public function setDeadline(TicketDeadline $deadline): static
    {
        $this->deadline = $deadline;

        return $this;
    }

    public function getSuggestedSolution(): ?string
    {
        return $this->suggested_solution;
    }

    public function setSuggestedSolution(?string $suggested_solution): static
    {
        $this->suggested_solution = $suggested_solution;

        return $this;
    }

    public function isNew(): ?bool
    {
        return $this->isNew;
    }

    public function setNew(bool $isNew): static
    {
        $this->isNew = $isNew;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, SuperTicket>
     */
    public function getChildTickets(): Collection
    {
        return $this->child_tickets;
    }

    public function addChildTicket(SuperTicket $childTicket): static
    {
        if (!$this->child_tickets->contains($childTicket)) {
            $this->child_tickets->add($childTicket);
            $childTicket->setParentFeedback($this);
        }

        return $this;
    }

    public function removeChildTicket(SuperTicket $childTicket): static
    {
        if ($this->child_tickets->removeElement($childTicket)) {
            // set the owning side to null (unless already changed)
            if ($childTicket->getParentFeedback() === $this) {
                $childTicket->setParentFeedback(null);
            }
        }

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }
}
