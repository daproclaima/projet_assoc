<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EvenementRepository")
 */
class Evenement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veuillez saisir un titre")
     */
    private $titre;


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $slug;


    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="veuillez saisir un contenu")
     * @Assert\Length(min="8", minMessage="Votre contenu est trop court")
     *
     */
    private $contenu;


    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $dateEvenement;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veuillez saisir un lieu")
     * @Assert\Length(min="8", minMessage="Vérifiez le lieu")
     */
    private $lieu;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(maxSize="2M", mimeTypesMessage="Vueillez verifier le format de votre image")
     * @Assert\NotBlank(message="veuillez insérer une image")
     *
     */
    private $featuredImage;


    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Veuillez saisir un prix")
     */
    private $prixAdulte;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prixEnfant;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie" ,
     *     inversedBy="evenements")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir une catégorie")
     */

    private $categories;


    public function __construct()
    {
        $this->categories = new ArrayCollection();
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

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateEvenement(): ?\DateTimeInterface
    {
        return $this->dateEvenement;
    }

    public function setDateEvenement(\DateTimeInterface $dateEvenement): self
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    public function setFeaturedImage($featuredImage): self
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }

    public function getPrixAdulte(): ?int
    {
        return $this->prixAdulte;
    }

    public function setPrixAdulte(int $prixAdulte): self
    {
        $this->prixAdulte = $prixAdulte;

        return $this;
    }

    public function getPrixEnfant(): ?int
    {
        return $this->prixEnfant;
    }

    public function setPrixEnfant(int $prixEnfant): self
    {
        $this->prixEnfant = $prixEnfant;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }
}
