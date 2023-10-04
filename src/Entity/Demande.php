<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DemandeRepository::class)]
class Demande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Question = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Réponse = null;

    #[ORM\Column(length: 255)]
    private ?string $Catégorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->Question;
    }

    public function setQuestion(string $Question): static
    {
        $this->Question = $Question;

        return $this;
    }

    public function getRéponse(): ?string
    {
        return $this->Réponse;
    }

    public function setRéponse(string $Réponse): static
    {
        $this->Réponse = $Réponse;

        return $this;
    }

    public function getCatégorie(): ?string
    {
        return $this->Catégorie;
    }

    public function setCatégorie(string $Catégorie): static
    {
        $this->Catégorie = $Catégorie;

        return $this;
    }
}
