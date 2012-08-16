<?php

namespace IMAG\PhdCallBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use IMAG\PhdCallBundle\Event\UserEvent;

class UserSubscriber implements EventSubscriberInterface
{
    static public function getSubscribedEvents()
    {
        return array(
            'phd_call.user.register.pre' => array('onUserRegisterPre', 128),
            'phd_call.user.register.post' => array('onUserRegisterPost', 0)
        );
    }

    public function onUserRegisterPre(UserEvent $event)
    {
        
    }

    public function onUserRegisterPost(UserEvent $event)
    {
        
    }
}
