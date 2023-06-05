<?php

namespace Panthir\Infrastructure\Repository\User;

use App\Shared\DTO\UserSearchPOPO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Panthir\Domain\User\Repository\UserRepositoryInterface;
use Panthir\Domain\User\Model\User;
use Panthir\Infrastructure\Repository\CountableTrait;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    use CountableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function search(UserSearchPOPO $search): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->where('1=1');

        if (!empty($search->getPage()) && !empty($search->getLimit())){
            $qb->setFirstResult(($search->getPage() - 1) * $search->getLimit())
                ->setMaxResults($search->getLimit());
        }

        if (!empty($search->getEmail())){
            $qb->andWhere('u.email = :email')
                ->setParameter(':email', $search->getEmail());
        }

        $results = $qb->getQuery()->getResult();
        $total = $this->countAllResults($qb, 'u.id');

        if (!empty($results)) {
            $results[0]->setTotalItems($total);
        }

        return $results;
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
    }
}