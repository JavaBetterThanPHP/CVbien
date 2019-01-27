<?php

namespace App\Repository;

use App\Entity\UserDiploma;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserDiploma|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDiploma|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDiploma[]    findAll()
 * @method UserDiploma[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDiplomaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserDiploma::class);
    }

    // /**
    //  * @return UserDiploma[] Returns an array of UserDiploma objects
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
    public function findOneBySomeField($value): ?UserDiploma
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
