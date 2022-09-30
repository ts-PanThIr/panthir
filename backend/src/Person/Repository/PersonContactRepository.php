<?php

namespace App\Person\Repository;

use App\Person\Entity\PersonContactEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonContactEntity>
 *
 * @method PersonContactEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonContactEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonContactEntity[]    findAll()
 * @method PersonContactEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonContactEntity::class);
    }
}
