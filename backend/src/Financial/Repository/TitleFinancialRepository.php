<?php

namespace App\Financial\Repository;

use App\Financial\Entity\TitleFinancialEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TitleFinancialEntity>
 *
 * @method TitleFinancialEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method TitleFinancialEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method TitleFinancialEntity[]    findAll()
 * @method TitleFinancialEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TitleFinancialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TitleFinancialEntity::class);
    }

}
