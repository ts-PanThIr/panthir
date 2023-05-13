<?php

namespace App\User\Repository;

use App\Shared\RepositoryTraits\CountableTrait;
use App\Shared\DTO\UserSearchDTO;
use App\User\Entity\UserEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<UserEntity>
 *
 * @method UserEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEntity[]    findAll()
 * @method UserEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    use CountableTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEntity::class);
    }

    public function remove(UserEntity $entity, bool $flush = false): void
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
        if (!$user instanceof UserEntity) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function search(UserSearchDTO $search): array
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
}
