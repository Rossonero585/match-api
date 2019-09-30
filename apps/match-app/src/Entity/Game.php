<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $team1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $team2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\League", inversedBy="games", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $league;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Sport", inversedBy="games", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $sport;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameBuffer", mappedBy="game")
     */
    private $gameBuffers;

    public function __construct()
    {
        $this->gameBuffers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTeam1(): ?Team
    {
        return $this->team1;
    }

    public function setTeam1(?Team $team1): self
    {
        $this->team1 = $team1;

        return $this;
    }

    public function getTeam2(): ?Team
    {
        return $this->team2;
    }

    public function setTeam2(?Team $team2): self
    {
        $this->team2 = $team2;

        return $this;
    }

    public function getLeague(): ?League
    {
        return $this->league;
    }

    public function setLeague(?League $league): self
    {
        $this->league = $league;

        return $this;
    }

    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    public function setSport(?Sport $sport): self
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * @return Collection|GameBuffer[]
     */
    public function getGameBuffers(): Collection
    {
        return $this->gameBuffers;
    }

    public function addGameBuffer(GameBuffer $gameBuffer): self
    {
        if (!$this->gameBuffers->contains($gameBuffer)) {
            $this->gameBuffers[] = $gameBuffer;
            $gameBuffer->setGame($this);
        }

        return $this;
    }

    public function removeGameBuffer(GameBuffer $gameBuffer): self
    {
        if ($this->gameBuffers->contains($gameBuffer)) {
            $this->gameBuffers->removeElement($gameBuffer);
            // set the owning side to null (unless already changed)
            if ($gameBuffer->getGame() === $this) {
                $gameBuffer->setGame(null);
            }
        }

        return $this;
    }
}
