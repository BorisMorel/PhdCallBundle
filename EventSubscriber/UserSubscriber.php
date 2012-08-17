<?php

namespace IMAG\PhdCallBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use IMAG\PhdCallBundle\Event\UserEvent;

class UserSubscriber implements EventSubscriberInterface
{
    static public function getSubscribedEvents()
    {
        return array(
            'phd_call.user.created.pre' => array('onUserCreatedPre', 128),
            'phd_call.user.created.post' => array('onUserCreatedPost', 0),
            'phd_call.user.updated.pre' => array('onUserUpdatedPre', 128),
            'phd_call.user.updated.post' => array('onUserUpdatedPost', 0),
        );
    }

    public function onUserCreatedPre(UserEvent $event)
    {
        
    }

    public function onUserCreatedPost(UserEvent $event)
    {
        
    }

    public function onUserUpdatedPre(UserEvent $event)
    {

    }

    public function onUserUpdatedPost(UserEvent $event)
    {

    }

}
