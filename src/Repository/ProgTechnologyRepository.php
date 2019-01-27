<?php

namespace App\Repository;

use App\Entity\ProgTechnology;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProgTechnology|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgTechnology|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgTechnology[]    findAll()
 * @method ProgTechnology[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgTechnologyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgTechnology::class);
    }

    // /**
    //  * @return ProgTechnology[] Returns an array of ProgTechnology objects
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
    public function findOneBySomeField($value): ?ProgTechnology
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
