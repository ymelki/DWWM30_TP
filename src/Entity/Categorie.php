<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Aproduit::class)]
    private Collection $aproduits;

    public function __construct()
    {
        $this->aproduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Aproduit>
     */
    public function getAproduits(): Collection
    {
        return $this->aproduits;
    }

    public function addAproduit(Aproduit $aproduit): self
    {
        if (!$this->aproduits->contains($aproduit)) {
            $this->aproduits->add($aproduit);
            $aproduit->setCategories($this);
        }

        return $this;
    }

    public function removeAproduit(Aproduit $aproduit): self
    {
        if ($this->aproduits->removeElement($aproduit)) {
            // set the owning side to null (unless already changed)
            if ($aproduit->getCategories() === $this) {
                $aproduit->setCategories(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
