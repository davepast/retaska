<?php

namespace App\Repository;

use App\Entity\PaymentOptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PaymentOptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentOptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentOptions[]    findAll()
 * @method PaymentOptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentOptionsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PaymentOptions::class);
    }

    // /**
    //  * @return PaymentOptions[] Returns an array of PaymentOptions objects
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
    public function findOneBySomeField($value): ?PaymentOptions
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
