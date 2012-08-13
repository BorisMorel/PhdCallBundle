<?php

namespace IMAG\PhdCallBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use IMAG\PhdCallBundle\Entity\Student;

class StudentEvent extends Event
{
    private 
        $student
        ;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function getStudent()
    {
        return $this->student;
    }
}