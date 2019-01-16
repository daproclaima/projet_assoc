<?php
/**
 * Created by PhpStorm.
 * User: boussaid
 * Date: 16/01/2019
 * Time: 17:07
 */

namespace App\Contact;

use Symfony\Component\Validator\Constraints as Assert;

class ContactezNous
{

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    /**
     * @Assert\NotBlank(message="veuillez saisir votre nom")
     */
    private $nom;

    /**
     *@Assert\NotBlank(message="veuillez saisir votre prénom")
     */
    private $prenom;

    /**
     *@Assert\NotBlank(message="veuillez saisir votre email")
     */
    private $email;

    /**
     *@Assert\NotBlank(message="veuillez saisir l'objet de votre contact")
     */
    private $objet;

    /**
     *@Assert\NotBlank(message="veuillez saisir votre message")
     */
    private $message;

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
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
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
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
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * @param mixed $objet
     */
    public function setObjet($objet): void
    {
        $this->objet = $objet;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }
}