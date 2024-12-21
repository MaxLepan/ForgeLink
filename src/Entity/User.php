<?php

namespace App\Entity;

use App\Enum\UserRoles;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $display_name;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, enumType: UserRoles::class)]
    private array $roles = [];

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'user')]
    private Collection $assigned_tickets;

    /**
     * @var Collection<int, SuperTicket>
     */
    #[ORM\OneToMany(targetEntity: SuperTicket::class, mappedBy: 'assignee')]
    private Collection $assigned_supertickets;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\ManyToMany(targetEntity: Project::class, mappedBy: 'team_members')]
    private Collection $projects;

    public function __construct()
    {
        $this->assigned_tickets = new ArrayCollection();
        $this->assigned_supertickets = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function setDisplayNameValue(): void
    {
        // $this->display_name = $this->first_name . ' ' . $this->last_name;
        $this->display_name = "John Doe";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    /**
     * @return UserRoles[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getAssignedTickets(): Collection
    {
        return $this->assigned_tickets;
    }

    public function addAssignedTicket(Ticket $assignedTicket): static
    {
        if (!$this->assigned_tickets->contains($assignedTicket)) {
            $this->assigned_tickets->add($assignedTicket);
            $assignedTicket->setUser($this);
        }

        return $this;
    }

    public function removeAssignedTicket(Ticket $assignedTicket): static
    {
        if ($this->assigned_tickets->removeElement($assignedTicket)) {
            // set the owning side to null (unless already changed)
            if ($assignedTicket->getUser() === $this) {
                $assignedTicket->setUser(null);
            }
        }

        return $this;
    }

    public function getDisplayName(): ?string
    {
        return $this->display_name;
    }

    public function setDisplayName(string $display_name): static
    {
        $this->display_name = $display_name;

        return $this;
    }

    /**
     * @return Collection<int, SuperTicket>
     */
    public function getAssignedSupertickets(): Collection
    {
        return $this->assigned_supertickets;
    }

    public function addAssignedSuperticket(SuperTicket $assignedSuperticket): static
    {
        if (!$this->assigned_supertickets->contains($assignedSuperticket)) {
            $this->assigned_supertickets->add($assignedSuperticket);
            $assignedSuperticket->setAssignee($this);
        }

        return $this;
    }

    public function removeAssignedSuperticket(SuperTicket $assignedSuperticket): static
    {
        if ($this->assigned_supertickets->removeElement($assignedSuperticket)) {
            // set the owning side to null (unless already changed)
            if ($assignedSuperticket->getAssignee() === $this) {
                $assignedSuperticket->setAssignee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->addTeamMember($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            $project->removeTeamMember($this);
        }

        return $this;
    }
}
