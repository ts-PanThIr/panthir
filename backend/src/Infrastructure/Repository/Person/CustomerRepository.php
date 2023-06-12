<?php

namespace Panthir\Infrastructure\Repository\Person;

use App\Shared\DTO\PersonSearchDTO;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Panthir\Domain\Customer\Model\Customer;
use Panthir\Domain\Customer\Repository\CustomerRepositoryInterface;

/**
 * @extends ServiceEntityRepository<Customer>
 *
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository implements CustomerRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
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
