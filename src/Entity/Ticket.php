<?php

namespace App\Entity;

use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Enum\TicketTypes;
use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\ManyToOne(inversedBy: 'assigned_tickets')]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'child_tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?SuperTicket $parent_superticket = null;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getParentSuperticket(): ?SuperTicket
    {
        return $this->parent_superticket;
    }

    public function setParentSuperticket(?SuperTicket $parent_superticket): static
    {
        $this->parent_superticket = $parent_superticket;

        return $this;
    }
}
