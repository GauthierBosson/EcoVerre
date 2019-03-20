<?php

namespace App\Repository;

use App\Entity\Trashs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Trashs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trashs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trashs[]    findAll()
 * @method Trashs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrashsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Trashs::class);
    }

    // /**
    //  * @return Trashs[] Returns an array of Trashs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Trashs
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
