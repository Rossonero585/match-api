<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @ORM\Table(indexes={@ORM\Index(name="full_name_idx", columns={"name_en","name_ru"}, flags={"fulltext"})})
 */
class Team implements Itranslated
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Sport")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sport;



    public function __construct()
    {
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
