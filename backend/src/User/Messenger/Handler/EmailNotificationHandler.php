<?php

namespace App\User\Messenger\Handler;

use App\User\Messenger\Model\EmailNotification;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class EmailNotificationHandler
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(EmailNotification $message): void
    {
        $email = (new TemplatedEmail())
            ->to($message->getUserEmail())
            ->subject('Password recover')
            ->htmlTemplate('emails/resetPassword.html.twig')
            ->context([
                'url' => 'http://localhost:5173/' . 'account/resetPassword/' . $message->getResetPasswordtoken(),
            ])
        ;

        $this->mailer->send($email);
    }
}