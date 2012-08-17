<?php

namespace IMAG\PhdCallBundle\Event;

final class PhdCallEvents
{
    /**
     * You can manipulate the User object before it was persisted
     *
     * @return IMAG\PhdCallBundle\Entity\User
     */
    const USER_CREATED_PRE = 'phd_call.user.created.pre';

    /**
     * You can retrieve final user informations
     */
    const USER_CREATED_POST = 'phd_call.user.created.post';

    /**
     * You can manipulate the User object before it was persisted
     *
     * @return IMAG\PhdCallBundle\Entity\User
     */
    const USER_UPDATED_PRE = 'phd_call.user.updated.pre';

    /**
     * You can retrieve final user informations
     */
    const USER_UPDATED_POST = 'phd_call.user.updated.post';

}