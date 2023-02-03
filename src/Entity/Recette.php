<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RecetteRepository::class)
 */
class Recette
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Unique()
     * @Assert\Length(min= 2, max= 100)
     */
    private $nom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Positive()
     */
    private $tempsPreparation;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\PositiveOrZero()
     */
    private $tempsCuisson;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive()
     */
    private $nbPersonnes;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $listeIngredients;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $etapes;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotNull()
     */
    private $dateAjout;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTempsPreparation(): ?int
    {
        return $this->tempsPreparation;
    }

    public function setTempsPreparation(int $tempsPreparation): self
    {
        $this->tempsPreparation = $tempsPreparation;

        return $this;
    }

    public function getTempsCuisson(): ?int
    {
        return $this->tempsCuisson;
    }

    public function setTempsCuisson(?int $tempsCuisson): self
    {
        $this->tempsCuisson = $tempsCuisson;

        return $this;
    }

    public function getNbPersonnes(): ?int
    {
        return $this->nbPersonnes;
    }

    public function setNbPersonnes(?int $nbPersonnes): self
    {
        $this->nbPersonnes = $nbPersonnes;

        return $this;
    }

    public function getListeIngredients(): ?string
    {
        return $this->listeIngredients;
    }

    public function setListeIngredients(string $listeIngredients): self
    {
        $this->listeIngredients = $listeIngredients;

        return $this;
    }

    public function getEtapes(): ?string
    {
        return $this->etapes;
    }

    public function setEtapes(string $etapes): self
    {
        $this->etapes = $etapes;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): self
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
