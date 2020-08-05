<?php

namespace App\Repository;

use App\Entity\SporPaket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SporPaket|null find($id, $lockMode = null, $lockVersion = null)
 * @method SporPaket|null findOneBy(array $criteria, array $orderBy = null)
 * @method SporPaket[]    findAll()
 * @method SporPaket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SporPaketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SporPaket::class);
    }

    // /**
    //  * @return SporPaket[] Returns an array of SporPaket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SporPaket
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
