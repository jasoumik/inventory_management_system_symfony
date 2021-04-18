<?php


namespace App\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StockInMailSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return[
            StockInMailEvent::NAME=>'onNewStockInCreated'
        ];
    }

    public function onNewStockInCreated(StockInMailEvent $event)
    {
        dump($event);

    }
}