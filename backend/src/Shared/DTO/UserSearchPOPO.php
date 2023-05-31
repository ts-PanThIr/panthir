<?php

namespace App\Shared\DTO;

use App\Shared\Transformer\AbstractPOPOTransformer;
use Symfony\Component\HttpFoundation\Request;

class UserSearchPOPO extends AbstractPOPOTransformer
{
    private ?int $id = null;
    private ?string $token = null;
    private ?int $limit = null;
    private ?int $page = null;
    private ?string $email = null;
    private ?string $profile = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): UserSearchPOPO
    {
        $this->id = $id;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): UserSearchPOPO
    {
        $this->token = $token;
        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function setLimit(?int $limit): UserSearchPOPO
    {
        $this->limit = $limit;
        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): UserSearchPOPO
    {
        $this->page = $page;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): UserSearchPOPO
    {
        $this->email = $email;
        return $this;
    }

    public function getProfile(): ?string
    {
        return $this->profile;
    }

    public function setProfile(?string $profile): UserSearchPOPO
    {
        $this->profile = $profile;
        return $this;
    }

    /**
     * @param Request $object
     * @return self
     */
    public static function transformFromObject(object $object): self
    {
        $dto = new UserSearchPOPO();
        if(!empty($object->query->get('email'))) {
            $dto->setEmail($object->query->get('email'));
        }
        if(!empty($object->query->get('limit'))) {
            $dto->setLimit($object->query->get('limit'));
        }
        if(!empty($object->query->get('page'))) {
            $dto->setPage($object->query->get('page'));
        }
        if(!empty($object->query->get('profile'))) {
            $dto->setProfile($object->query->get('profile'));
        }
        return $dto;
    }
}
