<?php

namespace App\Entity;

use App\Enum\TicketDeadline;
use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Enum\TicketTypes;
use App\Repository\SuperTicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuperTicketRepository::class)]
#[ORM\HasLifecycleCallbacks]
class SuperTicket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'child_tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Feedback $parent_feedback = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(enumType: TicketTypes::class)]
    private ?TicketTypes $type = null;

    #[ORM\Column(enumType: TicketPriority::class)]
    private ?TicketPriority $priority = null;

    #[ORM\Column(length: 511)]
    private ?string $description = null;

    #[ORM\Column(enumType: TicketStatus::class)]
    private ?TicketStatus $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'parent_superticket')]
    private Collection $child_tickets;

    #[ORM\ManyToOne(inversedBy: 'assigned_supertickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $assignee = null;

    #[ORM\Column(enumType: TicketDeadline::class)]
    private ?TicketDeadline $deadline = null;

    public function __construct()
    {
        $this->child_tickets = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentFeedback(): ?Feedback
    {
        return $this->parent_feedback;
    }

    public function setParentFeedback(?Feedback $parent_feedback): static
    {
        $this->parent_feedback = $parent_feedback;

        return $this;
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

    public function getType(): ?TicketTypes
    {
        return $this->type;
    }

    public function setType(TicketTypes $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPriority(): ?TicketPriority
    {
        return $this->priority;
    }

    public function setPriority(TicketPriority $priority): static
    {
        $this->priority = $priority;

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

    public function getStatus(): ?TicketStatus
    {
        return $this->status;
    }

    public function setStatus(TicketStatus $status): static
    {
        $this->status = $status;

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
     * @return Collection<int, Ticket>
     */
    public function getChildTickets(): Collection
    {
        return $this->child_tickets;
    }

    public function addChildTicket(Ticket $childTicket): static
    {
        if (!$this->child_tickets->contains($childTicket)) {
            $this->child_tickets->add($childTicket);
            $childTicket->setParentSuperticket($this);
        }

        return $this;
    }

    public function removeChildTicket(Ticket $childTicket): static
    {
        if ($this->child_tickets->removeElement($childTicket)) {
            // set the owning side to null (unless already changed)
            if ($childTicket->getParentSuperticket() === $this) {
                $childTicket->setParentSuperticket(null);
            }
        }

        return $this;
    }

    public function getAssignee(): ?User
    {
        return $this->assignee;
    }

    public function setAssignee(?User $assignee): static
    {
        $this->assignee = $assignee;

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
}
