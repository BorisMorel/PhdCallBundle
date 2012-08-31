<?php

namespace IMAG\PhdCallBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReviewerKey extends Constraint
{
    public $message = 'The given key is wrong';

    public function validatedBy()
    {
        return 'reviewer_key';
    }
}