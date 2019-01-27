<?php

namespace App\Repository;

use App\Entity\UserSociety;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserSociety|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSociety|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSociety[]    findAll()
 * @method UserSociety[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSocietyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserSociety::class);
    }

    // /**
    //  * @return UserSociety[] Returns an array of UserSociety objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserSociety
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
