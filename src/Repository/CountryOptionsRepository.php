<?php

namespace App\Repository;

use App\Entity\CountryOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CountryOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method CountryOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method CountryOptions[]    findAll()
 * @method CountryOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CountryOptionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CountryOptions::class);
    }

    // /**
    //  * @return CountryOptions[] Returns an array of CountryOptions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CountryOptions
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
