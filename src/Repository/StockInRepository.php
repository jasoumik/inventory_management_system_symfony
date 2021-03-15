<?php

namespace App\Repository;

use App\Entity\StockIn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
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
    public function getProductWiseBalance($date,$date1)
    {
        return $this->getEntityManager()->getConnection()
            ->executeQuery(
                'select a.name as pName,a.type,COALESCE(a.sum , 0)as stockIn , COALESCE(b.sum , 0) as Stockout , 
       COALESCE((COALESCE(a.sum , 0)-COALESCE(b.sum , 0))  , 0)  as balance
from        (select p.name ,pt.type,sum(si.quantity) sum from stock_in si inner join product p on si.product_id = p.id
            inner join product_type pt on p.product_type_id = pt.id
where si.date<=? group by p.name,pt.type) as a
left join  (select p.name ,pt.type,sum(si.quantity) sum from stock_out si inner join product p on si.product_id = p.id
               inner join product_type pt on p.product_type_id = pt.id
            where si.date<=? group by p.name,pt.type) as b
on a.name=b.name',
                [$date->format('Y-m-d H:i:s'),$date1->format('Y-m-d H:i:s')],
                [ParameterType::STRING,ParameterType::STRING] //We need DateTime Param here
            )->fetchAllAssociative();
    }

}
