<?php

namespace App\Service;

class MailerService{

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send($data, $view){
        $message = (new \Swift_Message($data['subject']))
                    ->setFrom('bloginteressantepacas@gmail.com')
                    ->setTo($data['email'])
                    ->setBody($view, 'text/html');

        return $this->mailer->send($message);
    }
}