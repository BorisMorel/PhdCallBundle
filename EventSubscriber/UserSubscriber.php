<?php

namespace IMAG\PhdCallBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use IMAG\PhdCallBundle\Event\UserEvent;

class UserSubscriber implements EventSubscriberInterface
{
    private 
        $mailer,
        $security
        ;

    public function __construct(\Swift_Mailer $mailer,
                                \Symfony\Component\Security\Core\Encoder\EncoderFactory $security
    )
    {
        $this->mailer = $mailer;
        $this->security = $security;
    }

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
        $user = $event->getUser();
        $encoder = $this->security->getEncoder($user);

        $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
    }
    
    public function onUserCreatedPost(UserEvent $event)
    {
        $user = $event->getUser();

        $message = \Swift_Message::newInstance()
            ->setSubject('[PERSYVAL] PhdCall Registration Completed')
            ->setFrom('phdcall@persyval-lab.fr')
            ->setTo($user->getEmail())
            ->setBody($user->getPlainPassword())
            ;

        if (!$this->mailer->send($message)) {
            throw new \Exception("Message can't be sending");
        }
    
    }

    public function onUserUpdatedPre(UserEvent $event)
    {

    }

    public function onUserUpdatedPost(UserEvent $event)
    {

    }

}
