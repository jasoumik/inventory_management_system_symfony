<?php


namespace App\Event;


use App\Entity\StockIn;
use Symfony\Contracts\EventDispatcher\Event;

class StockInMailEvent extends Event
{
    private $stockIn;
    const NAME ="stock.in.mailed";

    public function __construct(StockIn $stockIn)
    {
        $this->stockIn=$stockIn;
    }

//    public function getStockIn()
//    {
//        return $this->stockIn;
//    }

//    public function getProduct()
//    {
//       return $this->stockIn->getProduct();
//    }
}