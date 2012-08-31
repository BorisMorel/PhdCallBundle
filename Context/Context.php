<?php

namespace IMAG\PhdCallBundle\Context;

class Context
{
    private
        $config = array()
        ;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
    
    public function getMailerConfig()
    {       
        return $this->config['mailer'];
    }
}