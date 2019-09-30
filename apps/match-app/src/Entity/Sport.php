<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportRepository")
 * @ORM\Table(indexes={@ORM\Index(name="full_name_idx", columns={"name_en","name_ru"}, flags={"fulltext"})})
 */
class Sport implements Itranslated
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameEn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameRu;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\League", mappedBy="sport")
     */
    private $leagues;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Game", mappedBy="sport")
     */
    private $games;

    public function __construct()
    {
        $this->leagues = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|League[]
     */
    public function getLeagues(): Collection
    {
        return $this->leagues;
    }

    public function addLeague(League $league): self
    {
        if (!$this->leagues->contains($league)) {
            $this->leagues[] = $league;
            $league->setSport($this);
        }

        return $this;
    }

    public function removeLeague(League $league): self
    {
        if ($this->leagues->contains($league)) {
            $this->leagues->removeElement($league);
            // set the owning side to null (unless already changed)
            if ($league->getSport() === $this) {
                $league->setSport(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Game[]
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
            $game->setSport($this);
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        if ($this->games->contains($game)) {
            $this->games->removeElement($game);
            // set the owning side to null (unless already changed)
            if ($game->getSport() === $this) {
                $game->setSport(null);
            }
        }
        return $this;
    }


    public function getNameEn() : ?string
    {
        return $this->nameEn;
    }


    public function setNameEn(string $nameEn)
    {
        $this->nameEn = $nameEn;

        return $this;
    }

    public function getNameRu() : ?string
    {
        return $this->nameRu;
    }

    public function setNameRu(string $nameRu)
    {
        $this->nameRu = $nameRu;

        return $this;
    }

}
