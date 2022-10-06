<?php

namespace App\Financial\Repository;

use App\Financial\Entity\AccountsFinancialEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AccountsFinancialEntity>
 *
 * @method AccountsFinancialEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountsFinancialEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountsFinancialEntity[]    findAll()
 * @method AccountsFinancialEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountsFinancialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountsFinancialEntity::class);
    }

}
