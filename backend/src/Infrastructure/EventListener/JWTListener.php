<?php

namespace Panthir\Infrastructure\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Panthir\Domain\User\Model\User;

class JWTListener
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
    }

    public function onJWTDecoded(JWTDecodedEvent $event): void
    {
        $payload = $event->getPayload();
        $user = $this->entityManager->getRepository(User::class)->findOneBy(["email" => $payload['username']]);

        $payload['userId'] = $user->getId();

        $event->setPayload($payload);
    }
}
