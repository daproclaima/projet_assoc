<?php

namespace App\Membre;


use App\Entity\Membre;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MembreRequestHandler
{

    private $manager, $encoder;


    /**
     * MembreRequestHandler constructor.
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
    }

    public function handle(MembreRequest $membreRequest): Membre
    {

        $membre = new Membre();
        $membre
            ->setPrenom($membreRequest->getPrenom())
            ->setNom($membreRequest->getNom())
            ->setEmail($membreRequest->getEmail())
            ->setPassword($this->encoder->encodePassword($membre, $membreRequest->getPassword()))
            ->setTelephone($membreRequest->getTelephone())
            ->setAdresse($membreRequest->getAdresse())
            ->setCodePostal($membreRequest->getCodePostal())
            ->setVille($membreRequest->getVille())
            ->setRoles($membreRequest->getRoles())

        ;

        # Sauvegarde en BDD
        $em = $this->manager;
        $em->persist($membre);
        $em->flush();

        return $membre;
    }
}