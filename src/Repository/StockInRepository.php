<?php

namespace App\Repository;

use App\Entity\StockIn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

//use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @method StockIn|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockIn|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockIn[]    findAll()
 * @method StockIn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockInRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockIn::class);
    }

    // /**
    //  * @return StockIn[] Returns an array of StockIn objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function getQueryForCSV($queryDate)
    {
        return $this->createQueryBuilder('s')
            ->select('product.name', 'productType.type', 's.quantity','s.date')
            ->leftJoin('s.product', 'product')
            ->leftJoin('product.productType', 'productType')
            ->andWhere('s.date = :date')
            ->setParameter('date', $queryDate)
            ->getQuery()
            ->getResult();
    }

    public function getStockInQuantity($queryDate)
    {
        return $this->createQueryBuilder('s')
            ->select('product.name', 'SUM(s.quantity)')
            ->leftJoin('s.product', 'product')

            ->andWhere('s.date <= :date')
            ->setParameter('date', $queryDate)
            ->groupBy('product.name')
            ->getQuery()
            ->getResult();
    }


}
