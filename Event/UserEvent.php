<?php

namespace IMAG\PhdCallBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use IMAG\PhdCallBundle\Entity\User;

class UserEvent extends Event
{
    private 
        $user
        ;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}