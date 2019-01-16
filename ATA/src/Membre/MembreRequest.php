<?php

namespace App\Membre;

use App\Entity\Membre;
use Symfony\Component\Validator\Constraints as Assert;

class MembreRequest
{
    private $id;

    /**
     * @Assert\NotBlank(message="N'oubliez pas votre nom", groups={"registration", "update"})
     * @Assert\Length(max="50", maxMessage="Votre nom est trop long.
     * {{ limit }} caractères max. ", groups={"registration", "update"})
     */
    private $nom;

    /**
     * @Assert\NotBlank(message="N'oubliez pas votre prénom", groups={"registration", "update"})
     * @Assert\Length(max="50", maxMessage="Votre prénom est trop long.
     * {{ limit }} caractères max. ", groups={"registration", "update"})
     */
    private $prenom;

    /**
     * @Assert\Email(message="Vérifiez votre email.", groups={"registration", "update"})
     * @Assert\NotBlank(message="Saisissez votre email", groups={"registration", "update"})
     * @Assert\Length(max="80", maxMessage="Votre email est trop long. {{ limit }} caractères max.", groups={"registration", "update"})
     */
    private $email;

    /**
     * @Assert\NotBlank(message="N'oubliez pas votre mot de passe", groups={"registration"})
     * @Assert\Length(min="8", minMessage="Votre mot de passe est trop court. {{ limit }} caractères min.",
     *     max="20", maxMessage="Votre mot de passe est trop long. {{ limit }} caractères max.", groups={"registration"})
     * @Assert\Regex(
     *     pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/",
     *     message="Votre mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre.", groups={"registration"}
     * )
     */
    private $password;

    /**
     * @Assert\NotBlank(message="N'oubliez pas votre numéros de téléphone !", groups={"registration", "update"})
     * @Assert\Regex(pattern="/^0[1-9]?[0-9]\d{8}$/", message="Votre numéro de téléphone doit commencer par un 0 et doit contenir 10 chiffres", groups={"registration", "update"})
     */
    private $telephone;

    /**
     * @Assert\NotBlank(message="N'oubliez pas votre adresse !", groups={"registration", "update"})
     * @Assert\Length(min="8", minMessage="Vérifiez votre adresse !", groups={"registration", "update"})
     */
    private $adresse;

    /**
     * @Assert\NotBlank(message="N'oubliez pas le code postal", groups={"registration", "update"})
     * @Assert\Regex(pattern="/^[0-9]{5}$/",message="Vérifiez le code postal, il doit contenir 5 chiffres", groups={"registration", "update"})
     */
    private $codePostal;

    /**
     * @Assert\NotBlank(message="N'oubliez pas la ville !", groups={"registration", "update"})
     */
    private $ville;
    private $dateInscription;
    private $roles = [];

    /**
     * MembreRequest constructor.
     */
    public function __construct()
    {
        $this->dateInscription = new \DateTime();
    }

    /**
     * Récupération du membre dans membre request
     * @param Membre $membre
     * @return MembreRequest
     */
    public static function createFromMembre(Membre $membre): self
    {
        $membreRequest = new self();
        $membreRequest
            ->setPrenom($membre->getPrenom())
            ->setNom($membre->getNom())
            ->setEmail($membre->getEmail())
            ->setPassword($membre->getPassword())
            ->setTelephone($membre->getTelephone())
            ->setAdresse($membre->getAdresse())
            ->setCodePostal($membre->getCodePostal())
            ->setVille($membre->getVille())
            ->setRoles($membre->getRoles())
        ;

        return $membreRequest;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return MembreRequest
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     * @return MembreRequest
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     * @return MembreRequest
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return MembreRequest
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return MembreRequest
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     * @return MembreRequest
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param mixed $adresse
     * @return MembreRequest
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * @param mixed $codePostal
     * @return MembreRequest
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
        return $this;
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
     * @return MembreRequest
     */
    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateInscription(): \DateTime
    {
        return $this->dateInscription;
    }

    /**
     * @param \DateTime $dateInscription
     * @return MembreRequest
     */
    public function setDateInscription(\DateTime $dateInscription): MembreRequest
    {
        $this->dateInscription = $dateInscription;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return MembreRequest
     */
    public function setRoles(array $roles): MembreRequest
    {
        $this->roles = $roles;
        return $this;
    }

}
