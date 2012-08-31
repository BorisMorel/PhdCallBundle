<?php

namespace IMAG\PhdCallBundle\Notifier;

use Symfony\Bundle\TwigBundle\Debug\TimedTwigEngine;

use IMAG\PhdCallBundle\Context\Context;

class NotifierBase implements NotifierInterface
{
    private
        $mailer,
        $templating,
        $appContext,
        $template,
        $params = array()
        ;
    public function __construct(\Swift_mailer $mailer, TimedTwigEngine $templating, Context $appContext)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->appContext = $appContext;
        $this->params = $appContext->getMailerConfig();
    }

    public function setSubject($subject)
    {
        $this->params['subject'] = $subject;

        return $this;
    }

    public function getSubject()
    {
        return $this->params['subject'];
    }

    public function setTplParameters($params)
    {
        $this->params['tpl_params'] = (object)$params;

        return $this;
    }

    public function getTplParameters()
    {
        return $this->params['tpl_params'];
    }

    public function setFrom($from)
    {
        $this->params['from'] = $from;

        return $this;
    }

    public function getFrom()
    {
        return $this->params['from'];
    }

    public function setTo($to)
    {
        $this->params['to'] = $to;

        return $this;
    }

    public function getTo()
    {
        return $this->params['to'];
    }

    public function setTemplate($template)
    {
        $this->template = $template;

        return $this;
    }
    
    public function send()
    {
        $this->checkMandatoryFields();
        $this->checkTemplate();

        $message = \Swift_Message::newInstance()
            ->setSubject($this->params['subject'])
            ->setbody($this->templating->render($this->template, array('data' => $this->params['tpl_params'])))
            ->setFrom($this->params['from'])
            ->setTo($this->params['to'])
            ;
        
        if(!$mailer = $this->mailer->send($message)) {
            throw new \Exception("Message can't be sending");
        }
        
        return $mailer;
    }

    private function checkMandatoryFields()
    {
        foreach(array('subject', 'from', 'to') as $field)
            {
                if(!array_key_exists($field, $this->params))
                    throw new \Exception('Mandatory fields are subject, from and to');
            }
    }

    private function checkTemplate()
    {
        if (!$this->templating->exists($this->template)) {
            throw new \RuntimeException(sprintf('Template "%s" does not exist', $this->template));
        }
    }
}
