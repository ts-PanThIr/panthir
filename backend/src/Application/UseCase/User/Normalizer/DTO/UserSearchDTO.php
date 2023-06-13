<?php

namespace Panthir\Application\UseCase\User\Normalizer\DTO;

use Panthir\Application\Common\DTO\DTOInterface;

class UserSearchDTO implements DTOInterface
{
    public function __construct(
        private ?int $id = null,
        private ?string $token = null,
        private ?int $limit = null,
        private ?int $page = null,
        private ?string $email = null,
        private ?string $profile = null
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }
}
