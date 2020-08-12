<?php

namespace App\Repository\Admin;

use App\Entity\Admin\Purchase;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Purchase|null find($id, $lockMode = null, $lockVersion = null)
 * @method Purchase|null findOneBy(array $criteria, array $orderBy = null)
 * @method Purchase[]    findAll()
 * @method Purchase[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Purchase::class);
    }

    // /**
    //  * @return Purchase[] Returns an array of Purchase objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Purchase
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function getuserPurchase($id): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT o.*,p.title as pname  FROM purchase o
                JOIN spor_paket p ON p.id = o.paketid
                WHERE o.userid = :userid
                ORDER BY o.id DESC
                ';
        $stmt =$conn->prepare($sql);
        $stmt->execute(['userid'=>$id]);
        return $stmt->fetchAll();
    }
    public function getuserPurchases($status): array {
        $conn = $this->getEntityManager()->getConnection();
        $sql = '
                SELECT o.*,p.title as pname, usr.name as username  FROM purchase o
                JOIN spor_paket p ON p.id = o.paketid
                JOIN user usr ON usr.id = o.userid
                WHERE o.status =:status
                ';
        $stmt =$conn->prepare($sql);
        $stmt->execute(['status'=>$status]);
        return $stmt->fetchAll();
    }
}
