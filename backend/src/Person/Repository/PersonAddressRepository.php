<?php

namespace App\Person\Repository;

use App\Person\Entity\PersonAddressEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonAddressEntity>
 *
 * @method PersonAddressEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonAddressEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonAddressEntity[]    findAll()
 * @method PersonAddressEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonAddressEntity::class);
    }
}
