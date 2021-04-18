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
    public function getProductWiseBalance($date)
    {
        return $this->getEntityManager()->getConnection()
            ->executeQuery(
                'select distinct name,
       pt.type as productType,
       (select coalesce(sum(quantity), 0)
        from stock_in
        where date <= ?
          and product_id = product.id) as stockin,
(select coalesce( sum(quantity),0 )from stock_out where date<=? and product_id=product.id) as stockout
from product
         inner join product_type pt on pt.id = product.product_type_id
         inner join stock_in s on product.id=s.product_id',
                [$date->format('Y-m-d H:i:s'),$date->format('Y-m-d H:i:s')],
                [ParameterType::STRING,ParameterType::STRING]
            )->fetchAllAssociative();
    }
    public function getBalance($id)
    {
        return $this->getEntityManager()->getConnection()
            ->executeQuery('select  ((select coalesce(sum(quantity), 0) si
               from stock_in     where product_id = product.id)
           -  (select coalesce( sum(quantity),0 )from stock_out where  product_id=product.id)) as balance
            from product
            where id=?',
                [$id],
                [ParameterType::INTEGER]
            )->fetchOne();
    }

    public function stockInDateWise()
    {
        return $this->createQueryBuilder('si')
            ->select('product.id','si.date','si.quantity')
            ->leftJoin('si.product', 'product')
            ->groupBy('product.id','si.date','si.quantity')
            ->getQuery()
            ->getResult();
    }
    public function stockInDate()
    {

        return $this->createQueryBuilder('si')
            ->select('si.date')
            ->leftJoin('si.product', 'product')
            ->groupBy('si.date')
            ->orderBy('si.date')
            ->getQuery()
            ->getArrayResult();
    }
    public function stockInQuantity()
    {
        return $this->createQueryBuilder('si')
            ->select('si.quantity')
            ->leftJoin('si.product', 'product')

            ->orderBy('si.date')
            ->getQuery()
            ->getArrayResult();
    }
    public function highest5Quantity()
    {
        return $this->getEntityManager()->getConnection()
            ->executeQuery('select p.name,quantity from stock_in s  
    inner join product p on p.id=s.product_id where s.product_id=p.id
    order by quantity desc limit 5')->fetchAllAssociative();
    }
    public function lowest5Quantity()
    {
        return $this->getEntityManager()->getConnection()
            ->executeQuery('select p.name,quantity from stock_in s  
    inner join product p on p.id=s.product_id where s.product_id=p.id
    order by quantity limit 5')->fetchAllAssociative();
    }

}
