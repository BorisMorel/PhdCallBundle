<?php

namespace IMAG\PhdCallBundle\EventSubscriber\Entity;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use IMAG\PhdCallBundle\Event\Entity\UserEvent,
    IMAG\PhdCallBundle\Event\PhdCallEvents
    ;

class UserSubscriber implements EventSubscriberInterface
{
    private 
        $mailer,
        $security,
        $notifier
        ;

    public function __construct(\Swift_Mailer $mailer,
                                \Symfony\Component\Security\Core\Encoder\EncoderFactory $security,
                                \IMAG\PhdCallBundle\Notifier\NotifierInterface $notifier
    )
    {
        $this->mailer = $mailer;
        $this->security = $security;
        $this->notifier = $notifier;
    }

    static public function getSubscribedEvents()
    {
        return array(
            PhdCallEvents::USER_CREATED_PRE  => array('setCryptedPassword', 128),
            PhdCallEvents::USER_CREATED_POST => array('sendPlaintextPassword', 128),
            PhdCallEvents::USER_UPDATED_PRE  => array('onUserUpdatedPre', 128),
            PhdCallEvents::USER_UPDATED_POST => array('onUserUpdatedPost', 128),
        );
    }

    public function setCryptedPassword(UserEvent $event)
    {
        $user = $event->getUser();
        $encoder = $this->security->getEncoder($user);

        $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
    }
    
    public function sendPlaintextPassword(UserEvent $event)
    {
        $user = $event->getUser();

        $this->notifier
            ->setTo($user->getEmail())
            ->setTplParameters(array(
                'password' => $user->getPlainPassword()
            ))
            ->setTemplate('IMAGPhdCallBundle:Mail:registration.html.twig')
            ->send()
            ;    
    }

    public function onUserUpdatedPre(UserEvent $event)
    {

    }

    public function onUserUpdatedPost(UserEvent $event)
    {

    }

}
