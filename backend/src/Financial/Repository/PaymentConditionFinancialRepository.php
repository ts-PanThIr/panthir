<?php

namespace App\Financial\Repository;

use App\Financial\Entity\PaymentConditionFinancialEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PaymentConditionFinancialEntity>
 *
 * @method PaymentConditionFinancialEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentConditionFinancialEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentConditionFinancialEntity[]    findAll()
 * @method PaymentConditionFinancialEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentConditionFinancialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentConditionFinancialEntity::class);
    }

}
