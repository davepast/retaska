<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function displayTopThree()
    {
        return $this->findBy([], ['price' => 'DESC'], 3);
    }

    public function listAccToAlphabet()
    {
        return $this->findBy([], ['name' => 'ASC']);
    }

    public function listAccToAlphabetByCategory($categoryToDisplay)
    {
        return $this->findBy(['category' => $categoryToDisplay], ['name' => 'ASC']);
    }

    public function findForFinalStockChange(array $productsToOrder)
    {
        foreach ($productsToOrder as $productToOrderKey => $productToOrderValue)
        {
            $productToBeChecked = $this->findBy(['id' => $productToOrderKey]);

        }

    }

    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
