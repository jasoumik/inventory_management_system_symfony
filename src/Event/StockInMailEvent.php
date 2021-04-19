<?php


namespace App\Event;


use App\Entity\StockIn;
use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class StockInMailEvent extends Event
{
    private $stockIn;
    private $user;
    const NAME ="stock.in.mailed";

    public function __construct(StockIn $stockIn,User $user)
    {
        $this->stockIn=$stockIn;
        $this->user=$user;
    }

    public function getStockIn()
    {
        return $this->stockIn;
    }

    public function getUser()
    {
        return $this->user;
    }
}