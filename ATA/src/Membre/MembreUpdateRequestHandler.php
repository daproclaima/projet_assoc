<?php

namespace App\Membre;


use App\Entity\Membre;
use Doctrine\Common\Persistence\ObjectManager;

class MembreUpdateRequestHandler
{
    private $manager;


    /**
     * MembreRequestHandler constructor.
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function handle(MembreRequest $membreRequest, Membre $membre): Membre
    {

        $membre->update(
            $membreRequest->getPrenom(),
            $membreRequest->getNom(),
            $membreRequest->getEmail(),
            $membreRequest->getTelephone(),
            $membreRequest->getAdresse(),
            $membreRequest->getCodePostal(),
            $membreRequest->getVille()
        );

        $this->manager->flush();

        return $membre;

    }
    
}
