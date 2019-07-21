<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Elastica\Query;
use Elastica\Query\BoolQuery;
use FOS\ElasticaBundle\Repository;


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


    public function getUserSearchable()
    {
        $qb = $this->createQueryBuilder('u');

        return $qb
            ->where($qb->expr()->eq('u.isSearchable', ':isSearchable'))
            ->setParameter(':isSearchable', true);
    }

    public function search($search = null, $limit = 10)
    {
        $query = new Query();

        $boolQuery = new BoolQuery();

        if (!\is_null($search)) {
            $fieldQuery = new Query\MatchPhrasePrefix();
            $fieldQuery->setField('userProgLanguages', $search);

            $boolQuery->addMust($fieldQuery);
        }

        $query->setQuery($boolQuery);
        $query->setSize($limit);

        return $this->find($query);
    }
}
