<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le titre ne peut pas être vide.")
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)

     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Le contenu ne peut pas être vide.")
     */
    private $contenu;

    /**
     * /**
     * @ORM\Column(type="string", length=180, nullable=true)
     * @Assert\Image(
     *     mimeTypesMessage="Vérifier le format de votre image",
     *     maxSize= "1M", maxSizeMessage="Votre image est trop lourde"
     * )
     */
    private $featuredImage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $spotlight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Membre",
     *     inversedBy="articles")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $membre;

    /**
     * Article constructor.
     * @throws \Exception
     */
    public function __construct(){
        $this->dateCreation = new \DateTime();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu($contenu): self
    {
        $this->contenu = $contenu;

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

    public function getSpotlight(): ?bool
    {
        return $this->spotlight;
    }

    public function setSpotlight(bool $spotlight): self
    {
        $this->spotlight = $spotlight;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getMembre()
    {
        return $this->membre;
    }

    /**
     * @param mixed $membre
     */
    public function setMembre($membre):self
    {
        $this->membre = $membre;
        return $this;

    }

    /**
     * Vérifier qu'un membre est bien l'auteur de
     * l'article
     *
     * @param $membre
     * @return bool
     */
    public function isAuteur(?Membre $membre = null) :bool
    {
        return $membre && $this->getMembre()->getId() == $membre->getId();
    }


}
