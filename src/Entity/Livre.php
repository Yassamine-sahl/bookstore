<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\LivreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivreRepository::class)
 */
class Livre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=13)
    * @Assert\Regex("/97[89][- ]?[0-9]{1,5}[- ]?[0-9]+[- ]?[0-9]+[- ]?[0-9]$/")
     */
    private $isbn;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $nombre_pages;

    /**
     * @ORM\Column(type="date")
     * @Assert\Type("DateTime")
     */
    private $date_de_parution;

    /**
     * @ORM\Column(type="integer")
     * * @Assert\Range(
     *      min = 0,
     *      max = 20,
    *      notInRangeMessage = "Must be between {{ min }} and {{ max }}")
     */
    private $note;

    /**
     * @ORM\ManyToMany(targetEntity=Auteur::class, mappedBy="livres")
     */
    private $auteurs;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="livres")
     */
    private $genres;

    public function __construct()
    {
        $this->auteurs = new ArrayCollection();
        $this->genres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
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

    public function getNombrePages(): ?int
    {
        return $this->nombre_pages;
    }

    public function setNombrePages(int $nombre_pages): self
    {
        $this->nombre_pages = $nombre_pages;

        return $this;
    }

    public function getDateDeParution(): ?\DateTimeInterface
    {
        return $this->date_de_parution;
    }

    public function setDateDeParution(\DateTimeInterface $date_de_parution): self
    {
        $this->date_de_parution = $date_de_parution;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs[] = $auteur;
            $auteur->addLivre($this);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        if ($this->auteurs->removeElement($auteur)) {
            $auteur->removeLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection|Genre[]
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
    }
}
