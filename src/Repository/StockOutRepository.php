<?php

namespace App\Repository;

use App\Entity\StockOut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StockOut|null find($id, $lockMode = null, $lockVersion = null)
 * @method StockOut|null findOneBy(array $criteria, array $orderBy = null)
 * @method StockOut[]    findAll()
 * @method StockOut[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StockOutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StockOut::class);
    }

    // /**
    //  * @return StockOut[] Returns an array of StockOut objects
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

    public function getStockOutQuantity($queryDate)
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

    public function getStockInDate($id)
    {
        return $this->getEntityManager()->getConnection()
            ->executeQuery('select max(si.date) from stock_in si 
                   
                inner join product p on p.id = si.product_id
                where  si.product_id=?',
                [$id],
                [ParameterType::INTEGER]
            )->fetchOne();
    }
}
