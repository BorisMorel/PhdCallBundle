<?php

namespace IMAG\PhdCallBundle\Notifier;

use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;

use IMAG\PhdCallBundle\Context\Context;

interface NotifierInterface
{
    public function __construct(\Swift_mailer $mailer, TimedTwigEngine $templating, Context $appContext);

    public function setSubject($subject);

    public function getSubject();
        
    public function setTplParameters($params);

    public function getTplParameters();

    public function setFrom($from);

    public function getFrom();
    
    public function setTo($to);

    public function getTo();

    public function setTemplate($template);

    public function send();
}