<?php

namespace App\Person\Repository;

use App\Person\Entity\BrasilIndividualPersonEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BrasilIndividualPersonEntity>
 *
 * @method BrasilIndividualPersonEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method BrasilIndividualPersonEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method BrasilIndividualPersonEntity[]    findAll()
 * @method BrasilIndividualPersonEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrasilIndividualPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BrasilIndividualPersonEntity::class);
    }
}
