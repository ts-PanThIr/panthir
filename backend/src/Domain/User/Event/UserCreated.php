<?php

namespace Panthir\Domain\User\Event;

use Panthir\Domain\Common\Event\AbstractEvent;
use Panthir\Domain\Common\ValueObject\AggregateRootId;
use Panthir\Domain\Money\ValueObject\Currency;
use Panthir\Domain\Wallet\ValueObject\WalletId;

class UserCreated extends AbstractEvent
{
    public function __construct(
        private AggregateRootId $transactionId,
        private string $type,
        private WalletId $walletId,
        private AggregateRootId $userId,
        private int $real,
        private int $bonus,
        private Currency $currency,
        private \DateTime $createdAt
    ) {
        parent::__construct();

        $this->transactionId = $transactionId->__toString();
        $this->type = $type;
        $this->walletId = $walletId->__toString();
        $this->userId = $userId->__toString();
        $this->real = $real;
        $this->bonus = $bonus;
        $this->createdAt = $createdAt;
        $this->currency = $currency->code();
    }
}