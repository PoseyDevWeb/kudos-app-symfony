<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $fromEmployee; // Relation avec l'employé qui fait le remerciement

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $toEmployee;   // Relation avec l'employé qui est remercié

    #[ORM\Column(type: 'text')]
    private $reason;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime(); // Initialisation de la date de création
    }

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromEmployee(): ?User
    {
        return $this->fromEmployee;
    }

    public function setFromEmployee(?User $fromEmployee): self
    {
        $this->fromEmployee = $fromEmployee;

        return $this;
    }

    public function getToEmployee(): ?User
    {
        return $this->toEmployee;
    }

    public function setToEmployee(?User $toEmployee): self
    {
        $this->toEmployee = $toEmployee;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    // Optionnel : Vous pouvez ajouter un setter pour createdAt si nécessaire
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
