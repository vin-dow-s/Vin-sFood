<?php

namespace App\Entity;

use App\Repository\RecetteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=RecetteRepository::class)
 * @Vich\Uploadable()
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
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotNull()
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
     * @Assert\PositiveOrZero()
     */
    private $tempsRepos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive()
     */
    private $nbPersonnes;

    /**
     * @ORM\Column(type="string", length=85)
     * @Assert\NotBlank()
     * @Assert\Length(max=85)
     */
    private $apercuIngredients;

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


    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private \DateTimeImmutable $updatedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $listeIngredients;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="recette", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $thumbnail;

    /**
     * @ORM\Column(type="boolean")
     */
    private $veggie;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }


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

    public function getApercuIngredients(): ?string
    {
        return $this->apercuIngredients;
    }

    public function setApercuIngredients(string $apercuIngredients): self
    {
        $this->apercuIngredients = $apercuIngredients;

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

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable $updatedAt
     * @return Recette
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): Recette
    {
        $this->updatedAt = $updatedAt;

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

    public function getTempsRepos(): ?int
    {
        return $this->tempsRepos;
    }

    public function setTempsRepos(?int $tempsRepos): self
    {
        $this->tempsRepos = $tempsRepos;

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setRecette($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getRecette() === $this) {
                $image->setRecette(null);
            }
        }

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getPremiereImage()
    {
        $images = $this->getImages();
        return $images->isEmpty() ? null : $images->first();
    }

    public function isVeggie(): ?bool
    {
        return $this->veggie;
    }

    public function setVeggie(bool $veggie): self
    {
        $this->veggie = $veggie;

        return $this;
    }




}