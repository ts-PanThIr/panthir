<?php

namespace App\Shared\EventListener;

use App\Domain\User\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;

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
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(["email" => $payload['username']]);

        $payload['userId'] = $user->getId();

        $event->setPayload($payload);
    }
}
