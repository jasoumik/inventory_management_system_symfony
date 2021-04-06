<?php


namespace App\Event;
use Xiidea\EasyAuditBundle\Resolver\EmbeddedEventResolverInterface;
use Symfony\Contracts\EventDispatcher\Event;

class TypeEvent extends Event implements EmbeddedEventResolverInterface
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }


    public function getData()
    {
        return $this->data;
    }

    public function getEventLogInfo($eventName)
    {
        return array(
            'description'=>'Embeded Event description',
            'type'=>$eventName
        );
    }

}