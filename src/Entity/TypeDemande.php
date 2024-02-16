<?php

namespace App\Entity;

use App\Repository\TypeDemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeDemandeRepository::class)]
class TypeDemande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'typeDemande', targetEntity: Saisi::class)]
    private Collection $saisis;

    public function __construct()
    {
        $this->saisis = new ArrayCollection();
    }

    public function __toString() {
        return $this->label;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Saisi>
     */
    public function getSaisis(): Collection
    {
        return $this->saisis;
    }

    public function addSaisi(Saisi $saisi): static
    {
        if (!$this->saisis->contains($saisi)) {
            $this->saisis->add($saisi);
            $saisi->setTypeDemande($this);
        }

        return $this;
    }

    public function removeSaisi(Saisi $saisi): static
    {
        if ($this->saisis->removeElement($saisi)) {
            // set the owning side to null (unless already changed)
            if ($saisi->getTypeDemande() === $this) {
                $saisi->setTypeDemande(null);
            }
        }

        return $this;
    }

}
