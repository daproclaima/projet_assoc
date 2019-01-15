<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    const MAX_RESULTS = 3;


    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evenement::class);
    }


    # Récuperer tous les événemets par ordre decroissant d'Id
    public function findById()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    # Récuperer tous les événemets par ordre decroissant de date
    public function findBydate()
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.dateEvenement', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }



    #Récuperer les 3 derniers Evenement
    public function findLatestEvenements()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult()
            ;
    }


}
