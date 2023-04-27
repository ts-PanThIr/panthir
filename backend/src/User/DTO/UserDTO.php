<?php

namespace App\User\DTO;

use App\Person\Entity\PersonAccountEntity;
use App\Person\Entity\PersonEntity;
use App\Shared\Transformer\AbstractDTOTransformer;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Collections\ArrayCollection;

class UserDTO extends AbstractDTOTransformer
{
    public function __construct(
        #[Groups(['user'])]
        private string $email,

        #[Groups(['user'])]
        private Collection $projects = new ArrayCollection(),

        #[Groups(['user'])]
        private ?int $id = null,

        #[Groups(['user'])]
        private PersonAccountEntity|null $account = null,

        #[Groups(['user'])]
        private PersonEntity|null $client = null,

        #[Groups(['user'])]
        private array $roles = [],

        private ?string $password = null,
        private ?string $passwordResetToken = null
    )
    {
    }

    public static function transformFromObject(object $object): self
    {
        return new UserDTO(
            email: $object->getEmail()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): UserDTO
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserDTO
    {
        $this->email = $email;
        return $this;
    }

    public function getAccount(): ?PersonAccountEntity
    {
        return $this->account;
    }

    public function setAccount(?PersonAccountEntity $account): UserDTO
    {
        $this->account = $account;
        return $this;
    }

    public function getClient(): ?PersonEntity
    {
        return $this->client;
    }

    public function setClient(?PersonEntity $client): UserDTO
    {
        $this->client = $client;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): UserDTO
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): UserDTO
    {
        $this->password = $password;
        return $this;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): UserDTO
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function setProjects(Collection $projects): UserDTO
    {
        $this->projects = $projects;
        return $this;
    }
}