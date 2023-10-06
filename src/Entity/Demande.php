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
    private ?string $Reponse = null;

    #[ORM\Column(length: 255)]
    private ?string $Categorie = null;

    #[ORM\Column(length: 255)]
    private ?string $SousCategorie = null;

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

    public function getReponse(): ?string
    {
        return $this->Reponse;
    }

    public function setReponse(string $Reponse): static
    {
        $this->Reponse = $Reponse;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->Categorie;
    }

    public function setCategorie(string $Categorie): static
    {
        $this->Categorie = $Categorie;

        return $this;
    }

    public function getSousCategorie(): ?string
    {
        return $this->SousCategorie;
    }

    public function setSousCategorie(string $SousCategorie): static
    {
        $this->SousCategorie = $SousCategorie;

        return $this;
    }
}
