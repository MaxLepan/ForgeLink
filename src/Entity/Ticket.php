<?php

namespace App\Entity;

use App\Enum\TicketPriority;
use App\Enum\TicketStatus;
use App\Enum\TicketTypes;
use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket extends TicketParent
{
    // #[ORM\Id]
    // #[ORM\GeneratedValue]
    // #[ORM\Column]
    // private ?int $id = null;

    // #[ORM\Column(length: 255)]
    // private ?string $title = null;

    #[ORM\Column(enumType: TicketTypes::class)]
    private ?TicketTypes $type = null;

    #[ORM\Column(enumType: TicketPriority::class)]
    private ?TicketPriority $priority = null;

    #[ORM\ManyToOne(targetEntity: TicketParent::class)]
    #[ORM\JoinColumn(nullable: true)]
    private TicketParent $parent;

    // #[ORM\Column(length: 511)]
    // private ?string $description = null;

    #[ORM\Column(enumType: TicketStatus::class)]
    private ?TicketStatus $status = null;

    #[ORM\ManyToOne(inversedBy: 'assigned_tickets')]
    private ?User $user = null;

    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // private ?\DateTimeInterface $createdAt = null;

    // public function getId(): ?int
    // {
    //     return $this->id;
    // }

    // public function getTitle(): ?string
    // {
    //     return $this->title;
    // }

    // public function setTitle(string $title): static
    // {
    //     $this->title = $title;

    //     return $this;
    // }

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

    public function getParent(): mixed
    {
        return $this->parent;
    }

    public function setParent(mixed $parent): static
    {
        if ($parent instanceof self || $parent instanceof Feedback) {
            $this->parent = $parent;
            return $this;
        } else {
            throw new \InvalidArgumentException('Parent must be an instance of Ticket or Feedback');
        }
    }

    // public function getDescription(): ?string
    // {
    //     return $this->description;
    // }

    // public function setDescription(string $description): static
    // {
    //     $this->description = $description;

    //     return $this;
    // }

    public function getStatus(): ?TicketStatus
    {
        return $this->status;
    }

    public function setStatus(TicketStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    // public function getCreatedAt(): ?\DateTimeInterface
    // {
    //     return $this->createdAt;
    // }

    // public function setCreatedAt(\DateTimeInterface $createdAt): static
    // {
    //     $this->createdAt = $createdAt;

    //     return $this;
    // }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
