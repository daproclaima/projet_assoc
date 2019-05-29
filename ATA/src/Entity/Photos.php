<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhotosRepository")
 */
class Photos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="N'oubliez pas le titre le photo")
     * @Assert\Length(
     *     min = 2,
     *     max = 50,
     *     minMessage = "Le titre de la photo doit contenir au moins  {{ limit }} caratères",
     *     maxMessage = "Le titre de la photo doit contenir moins de {{ limit }} caratères"
     * )
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous n'avez pas fourni d'image")
     * @Assert\File(
     *     mimeTypes={ "image/png", "image/jpeg" },
     *     mimeTypesMessage =  "Votre image doit être au format png ou jpeg."
     * )
     */
    private $featuredImage;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\DateTime(format="d-M-Y")
     * @Assert\NotBlank(message="N'oubliez pas la photo !")
     */
    private $dateAlbum;


    public function __construct()
    {
        $this->dateAlbum = new \DateTime();
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

    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    public function setFeaturedImage( $featuredImage): self
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlbum()
    {
        return $this->album;
    }

    /**
     * @param mixed $album
     */
    public function setAlbum($album): void
    {
        $this->album = $album;
    }
}
