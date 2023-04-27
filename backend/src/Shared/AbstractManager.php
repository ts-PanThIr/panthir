<?php

namespace App\Shared;

use App\Shared\Notify\Notify;
use Doctrine\ORM\EntityManagerInterface;

abstract class AbstractManager
{
    public function __construct (
        protected readonly EntityManagerInterface       $entityManager,
        protected readonly Notify                       $notify
    )
    {
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}