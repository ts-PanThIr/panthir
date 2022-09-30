<?php

namespace App\Person\Repository;

use App\Person\Entity\IndividualPersonEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IndividualPersonEntity>
 *
 * @method IndividualPersonEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method IndividualPersonEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method IndividualPersonEntity[]    findAll()
 * @method IndividualPersonEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IndividualPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IndividualPersonEntity::class);
    }

}
