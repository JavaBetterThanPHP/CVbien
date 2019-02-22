<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /** Retourne une liste de Users à purger pour GDPR
     *  $time : le nombre d'année à retirer
     */
    public function getUserToDelete($time)
    {
        $date = new \DateTime();
        $date->modify('-'.$time.' years');

        $qb = $this->createQueryBuilder('u')
            ->Where('u.date_derniere_connexion < :value')
            ->setParameter('value', $date)
            ->andWhere('u.isActive = :isActive')
            ->setParameter('isActive', true);

        return $qb->getQuery()->getResult();
    }
}
