<?php

namespace IMAG\PhdCallBundle\Event;

final class PhdCallEvents
{
    /**
     * You can manipulate the Student object before it was persisted
     *
     * @return IMAG\PhdCallBundle\Entity\Student
     */
    const STUDENT_PRE_REGISTER = 'phd_call.student.register.pre';

    /**
     * You can retrieve final student informations
     */
    const STUDENT_POST_REGISTER = 'phd_call.student.register.post';

}