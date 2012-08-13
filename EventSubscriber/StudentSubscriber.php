<?php

namespace IMAG\PhdCallBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use IMAG\PhdCallBundle\Event\StudentEvent;

class StudentSubscriber implements EventSubscriberInterface
{
    static public function getSubscribedEvents()
    {
        return array(
            'phd_call.student.register.pre' => array('onStudentRegisterPre', 128),
            'phd_call.student.register.post' => array('onStudentRegisterPost', 0)
        );
    }

    public function onStudentRegisterPre(StudentEvent $event)
    {
        
    }

    public function onStudentRegisterPost(StudentEvent $event)
    {
        
    }
}
