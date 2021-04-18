<?php


namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class UserRegisteredEvent extends Event
{
    const NAME = 'user.registered';
    protected $user;

    public function __construct(User $user) {
        $this->user = $user;
   }
    public function getUser() {
        return $this->user;
   }

}