<?php

namespace App\User\Entity;

use App\Person\Entity\PersonAccountEntity;
use App\Person\Entity\PersonEntity;
use App\Project\Entity\ProjectEntity;
use App\User\UserRoles;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Blameable\Traits\BlameableEntity;
use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class UserEntity implements UserInterface, PasswordAuthenticatedUserInterface
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user', 'client'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['user', 'client'])]
    private string $email;

    #[ManyToOne(targetEntity: PersonAccountEntity::class, inversedBy: 'users')]
    #[JoinColumn(name: 'account_id', referencedColumnName: 'id')]
    private PersonAccountEntity|null $account = null;


    #[ManyToOne(targetEntity: PersonEntity::class, inversedBy: 'users')]
    #[JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    private PersonEntity|null $client = null;

    #[ORM\Column]
    #[Groups(['user'])]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: "text", length: 10000, nullable: true)]
    private ?string $passwordResetToken = null;

    #[ManyToMany(targetEntity: ProjectEntity::class, mappedBy: 'users')]
    private Collection $projects;

    #[Groups(['user', 'client'])]
    private string $profile;

    public function __construct() {
        $this->projects = new ArrayCollection();
    }

    public function getProfile(): string
    {
        return UserRoles::getProfileByRoles($this->getRoles());
    }

    public function setProfile(string $profile): self
    {
        $this->profile = $profile;
        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
//        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getAccount(): ?PersonAccountEntity
    {
        return $this->account;
    }

    public function setAccount(?PersonAccountEntity $account): UserEntity
    {
        $this->account = $account;
        return $this;
    }

    public function getClient(): ?PersonEntity
    {
        return $this->client;
    }

    public function setClient(?PersonEntity $client): UserEntity
    {
        $this->client = $client;
        return $this;
    }

    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function setProjects(Collection $projects): UserEntity
    {
        $this->projects = $projects;
        return $this;
    }

    public function getPasswordResetToken(): ?string
    {
        return $this->passwordResetToken;
    }

    public function setPasswordResetToken(?string $passwordResetToken): UserEntity
    {
        $this->passwordResetToken = $passwordResetToken;
        return $this;
    }
}
