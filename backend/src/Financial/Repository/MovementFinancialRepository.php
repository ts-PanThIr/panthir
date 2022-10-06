<?php

namespace App\Financial\Repository;

use App\Financial\Entity\MovementFinancialEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovementFinancialEntity>
 *
 * @method MovementFinancialEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovementFinancialEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovementFinancialEntity[]    findAll()
 * @method MovementFinancialEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovementFinancialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovementFinancialEntity::class);
    }

}
