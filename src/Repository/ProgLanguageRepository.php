<?php

namespace App\Repository;

use App\Entity\ProgLanguage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProgLanguage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProgLanguage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProgLanguage[]    findAll()
 * @method ProgLanguage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgLanguageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProgLanguage::class);
    }

    public function findNameContaining($key) {
        $query = $this->getEntityManager()
            ->createQuery("
	            SELECT p FROM App\Entity\ProgLanguage p
	            WHERE p.name LIKE :key
	            ORDER BY LENGTH(p.name) ASC"
            );
        $query->setParameter('key', '%'.strtolower($key).'%')
        ->setMaxResults(10);
        return $query->getResult();
    }

    // /**
    //  * @return ProgLanguage[] Returns an array of ProgLanguage objects
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
    public function findOneBySomeField($value): ?ProgLanguage
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
