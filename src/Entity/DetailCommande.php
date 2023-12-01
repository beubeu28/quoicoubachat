<?php

namespace App\Entity;

use App\Repository\DetailCommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailCommandeRepository::class)]
class DetailCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prixUnitaire = null;

    #[ORM\Column]
    private ?float $prixTotal = null;

    #[ORM\ManyToOne(inversedBy: 'detailCommandes')]
    private ?Commande $commandeid = null;

    #[ORM\ManyToOne(inversedBy: 'detailCommandes')]
    private ?Article $articleid = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrixUnitaire(): ?float
    {
        return $this->prixUnitaire;
    }

    public function setPrixUnitaire(float $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): static
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getCommandeid(): ?Commande
    {
        return $this->commandeid;
    }

    public function setCommandeid(?Commande $commandeid): static
    {
        $this->commandeid = $commandeid;

        return $this;
    }

    public function getArticleid(): ?Article
    {
        return $this->articleid;
    }

    public function setArticleid(?Article $articleid): static
    {
        $this->articleid = $articleid;

        return $this;
    }
}
