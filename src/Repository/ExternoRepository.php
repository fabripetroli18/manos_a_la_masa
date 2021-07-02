<?php

namespace App\Repository;

use App\Entity\Externo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Externo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Externo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Externo[]    findAll()
 * @method Externo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExternoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Externo::class);
    }

    // /**
    //  * @return Externo[] Returns an array of Externo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Externo
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
