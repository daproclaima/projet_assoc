<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MembreRepository")
 * @UniqueEntity(fields={"email"}, errorPath="email",message="Ce compte existe déjà !")
 */
class Membre implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="N'oubliez pas votre nom")
     * @Assert\Length(max="50", maxMessage="Votre nom est trop long.
     * {{ limit }} caractères max. ")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="N'oubliez pas votre prénom")
     * @Assert\Length(max="50", maxMessage="Votre prénom est trop long.
     * {{ limit }} caractères max. ")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=80)
     * @Assert\Email(message="Vérifiez votre email.")
     * @Assert\NotBlank(message="Saisissez votre email")
     * @Assert\Length(max="80", maxMessage="Votre email est trop long. {{ limit }} caractères max.")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank(message="N'oubliez pas votre mot de passe")
     * @Assert\Length(min="8", minMessage="Votre mot de passe est trop court. {{ limit }} caractères min.",
     *     max="20", maxMessage="Votre mot de passe est trop long. {{ limit }} caractères max.")
     * @Assert\Regex(
     *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/",
     *     message="Votre mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre."
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank(message="N'oubliez pas votre numéros de téléphone !")
     * @Assert\Regex(pattern="/^0[1-9]?[0-9]\d{8}$/", message="Votre numéro de téléphone doit commencer par un 0 et doit contenir 10 chiffres")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="N'oubliez pas votre adresse !")
     * @Assert\Length(min="8", minMessage="Vérifiez votre adresse !")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=5)
     * @Assert\NotBlank(message="N'oubliez pas le code postal")
     * @Assert\Regex(pattern="/^[0-9]{5}$/",message="Vérifiez le code postal, il doit contenir 5 chiffres")
     */
    private $codePostal;
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="N'oubliez pas la ville !")
     */
    private $ville;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateInscription;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $paiement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Paiement",
     *     mappedBy="membre", cascade={"remove"})
     */
    private $checkPaiement;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article",
     *     mappedBy="membre", cascade={"remove"})
     * @return int|null
     */
    private $articles;

    /**
     * @var string le token qui servira lors de l'oubli de mot de passe
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $resetToken;

    /**
     * @return string
     */
    public function getResetToken()
    {
        return $this->resetToken;
    }

    /**
     * @param string $resetToken
     */
    public function setResetToken($resetToken)
    {
        $this->resetToken = $resetToken;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->dateInscription =new \DateTime();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    public function getRoles(): ?array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPaiement(): ?string
    {
        return $this->paiement;
    }

    public function setPaiement(string $paiement): self
    {
        $this->paiement = $paiement;

        return $this;
    }
    /**
    * Returns the salt that was originally used to encode the password.
    *
    * This can return null if the password was not encoded using a salt.
    *
    * @return string|null The salt
    */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return mixed
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * @param mixed $ville
     */
    public function setVille($ville): void
    {
        $this->ville = $ville;
    }

    /**
     * @return mixed
     */
    public function getCheckPaiement()
    {
        return $this->checkPaiement;
    }

    /**
     * @param mixed $checkPaiement
     */
    public function setCheckPaiement($checkPaiement): void
    {
        $this->checkPaiement = $checkPaiement;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles): void
    {
        $this->articles = $articles;
    }

}
