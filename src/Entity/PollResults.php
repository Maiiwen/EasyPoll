<?php

namespace App\Entity;

use App\Repository\PollResultsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: PollResultsRepository::class)]
class PollResults
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['poll:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'uuid')]
    #[Groups(['poll:read'])]
    private ?Uuid $uuid = null;

    #[ORM\Column(length: 255)]
    #[Groups(['poll:read'])]
    private ?string $client_number = null;

    #[ORM\Column(length: 255)]
    #[Groups(['poll:read'])]
    private ?string $customer_mail = null;

    #[ORM\Column(type: 'json', length: 255)]
    #[Groups(['poll:read'])]
    private ?string $poll_data = null;

    #[ORM\ManyToOne(inversedBy: 'pollResults')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['poll:read'])]
    private ?Poll $poll = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getClientNumber(): ?string
    {
        return $this->client_number;
    }

    public function setClientNumber(string $client_number): self
    {
        $this->client_number = $client_number;

        return $this;
    }

    public function getCustomerMail(): ?string
    {
        return $this->customer_mail;
    }

    public function setCustomerMail(string $customer_mail): self
    {
        $this->customer_mail = $customer_mail;

        return $this;
    }

    public function getPollData(): ?string
    {
        return $this->poll_data;
    }

    public function setPollData(string $poll_data): self
    {
        $this->poll_data = $poll_data;

        return $this;
    }

    public function getPoll(): ?Poll
    {
        return $this->poll;
    }

    public function setPoll(?Poll $poll): self
    {
        $this->poll = $poll;

        return $this;
    }
}
