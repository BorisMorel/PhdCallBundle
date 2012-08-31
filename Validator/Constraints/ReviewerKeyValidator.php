<?php

namespace IMAG\PhdCallBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint,
    Symfony\Component\Validator\ConstraintValidator
    ;

use IMAG\PhdCallBundle\Context\Context;

class ReviewerKeyValidator extends ConstraintValidator
{
    private
        $config
        ;

    public function __construct(Context $config)
    {
        $this->config = $config;
    }

    public function validate($value, Constraint $constraint)
    {
        $params = $this->config->getConfig();
        
        if (0 != strcmp($params['reviewer_pass'], $value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
