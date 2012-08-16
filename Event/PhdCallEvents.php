<?php

namespace IMAG\PhdCallBundle\Event;

final class PhdCallEvents
{
    /**
     * You can manipulate the User object before it was persisted
     *
     * @return IMAG\PhdCallBundle\Entity\User
     */
    const USER_PRE_REGISTER = 'phd_call.user.register.pre';

    /**
     * You can retrieve final user informations
     */
    const USER_POST_REGISTER = 'phd_call.user.register.post';

}