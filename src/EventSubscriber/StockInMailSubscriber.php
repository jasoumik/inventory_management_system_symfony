<?php


namespace App\EventSubscriber;


use App\Entity\User;
use App\Event\StockInMailEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Templating\EngineInterface;
use Twig\Environment;

class StockInMailSubscriber implements EventSubscriberInterface
{

    private \Swift_Mailer $mailer;
    private $engine;

    public function __construct(\Swift_Mailer $mailer, Environment $engine){
        $this->mailer=$mailer;
        $this->engine=$engine;
    }
    public static function getSubscribedEvents()
    {
        return[
            StockInMailEvent::NAME=>'onNewStockInCreated'
        ];
    }

    public function onNewStockInCreated(StockInMailEvent $event)
    {
//        dump($event);
  // dump($event->getUser()->getName());
       $stockIn=$event->getStockIn();
       $message=(new \Swift_Message($stockIn->getProduct()->getName().' is added in Stock'))
               ->setFrom('jasoumik.backend@gmail.com')
               ->setTo('jasoumik@gmail.com')
               ->setBody($this->engine->render('mail/mail.html.twig',
       [
           'user'=>$event->getUser()->getName(),
           'qty'=>$stockIn->getQuantity(),
           'type'=>$stockIn->getProduct()->getProductType()->getType()
       ]),'text/html');
       return $this->mailer->send($message);


    }
}