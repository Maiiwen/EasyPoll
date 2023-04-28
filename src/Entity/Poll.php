<?php

namespace App\Entity;

use App\Repository\PollRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PollRepository::class)]
class Poll
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['poll:read'])]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'poll', targetEntity: Question::class)]
    #[Groups(['poll:read'])]
    private Collection $questions;

    #[ORM\OneToMany(mappedBy: 'poll', targetEntity: PollResults::class)]
    private Collection $pollResults;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
        $this->pollResults = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
            $question->setPoll($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->removeElement($question)) {
            // set the owning side to null (unless already changed)
            if ($question->getPoll() === $this) {
                $question->setPoll(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PollResults>
     */
    public function getPollResults(): Collection
    {
        return $this->pollResults;
    }

    public function addPollResult(PollResults $pollResult): self
    {
        if (!$this->pollResults->contains($pollResult)) {
            $this->pollResults->add($pollResult);
            $pollResult->setPoll($this);
        }

        return $this;
    }

    public function removePollResult(PollResults $pollResult): self
    {
        if ($this->pollResults->removeElement($pollResult)) {
            // set the owning side to null (unless already changed)
            if ($pollResult->getPoll() === $this) {
                $pollResult->setPoll(null);
            }
        }

        return $this;
    }
}
