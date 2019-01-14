<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veuillez saisir une adresse")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="veuillez saisir la ville")
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="veuillez saisir le code postal")
     */
    private $codePostal;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="veuillez saisir votre numero de telephone")
     * @Assert\Regex(pattern="/^0[1-9]?[0-9]\d{8}$/", message="Votre numéro de téléphone doit commencer par un 0 et doit contenir 10 chiffres")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Email(message="Vérifiez votre email.")
     * @Assert\NotBlank(message="veuillez saisir votre adresse email")
     * @Assert\Length(max="80", maxMessage="Votre email est trop long. {{ limit }} caractères max.")
     */
    private $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
