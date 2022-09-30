<?php

namespace App\Person\Repository;

use App\Person\Entity\PortugalIndividualPersonEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortugalIndividualPersonEntity>
 *
 * @method PortugalIndividualPersonEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortugalIndividualPersonEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortugalIndividualPersonEntity[]    findAll()
 * @method PortugalIndividualPersonEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortugalIndividualPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortugalIndividualPersonEntity::class);
    }
}
