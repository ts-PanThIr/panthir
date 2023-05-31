<?php

namespace Panthir\Infrastructure\Repository\Person;

use App\Shared\DTO\PersonSearchDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Panthir\Domain\Person\Model\Person;
use Panthir\Domain\Person\Repository\PersonRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Person>
 *
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository implements PersonRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function search(PersonSearchDTO $search): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p, addresses')
            ->leftJoin('p.addresses', 'addresses')
        ;
        return $qb->getQuery()->getResult();
    }
}
