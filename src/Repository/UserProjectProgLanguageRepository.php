<?php

namespace App\Repository;

use App\Entity\UserProjectProgLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserProjectProgLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserProjectProgLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserProjectProgLanguage[]    findAll()
 * @method UserProjectProgLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserProjectProgLanguageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserProjectProgLanguage::class);
    }

    // /**
    //  * @return UserProjectProgLanguage[] Returns an array of UserProjectProgLanguage objects
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
    public function findOneBySomeField($value): ?UserProjectProgLanguage
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
