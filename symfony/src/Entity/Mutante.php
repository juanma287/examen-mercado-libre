<?php

namespace App\Entity;

use App\Repository\MutanteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MutanteRepository::class)
 */
class Mutante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $ismutant;

    /**
     * @ORM\Column(type="json")
     */
    private $dna = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsmutant(): ?bool
    {
        return $this->ismutant;
    }

    public function setIsmutant(bool $ismutant): self
    {
        $this->ismutant = $ismutant;

        return $this;
    }

    public function getDna(): ?array
    {
        return $this->dna;
    }

    public function setDna(array $dna): self
    {
        $this->dna = $dna;

        return $this;
    }
}
