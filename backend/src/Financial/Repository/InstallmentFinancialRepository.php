<?php

namespace App\Financial\Repository;

use App\Financial\Entity\InstallmentFinancialEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InstallmentFinancialEntity>
 *
 * @method InstallmentFinancialEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstallmentFinancialEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstallmentFinancialEntity[]    findAll()
 * @method InstallmentFinancialEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstallmentFinancialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstallmentFinancialEntity::class);
    }

}
