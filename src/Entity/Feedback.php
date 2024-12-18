<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
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

    #[ORM\Column(length: 255)]
    private ?string $deadline = null;

    #[ORM\Column(length: 511, nullable: true)]
    private ?string $suggested_solution = null;

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

    public function getDeadline(): ?string
    {
        return $this->deadline;
    }

    public function setDeadline(string $deadline): static
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
}
