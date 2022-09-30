<?php

namespace App\Person\Repository;

use App\Person\Entity\JuridicalPersonEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JuridicalPersonEntity>
 *
 * @method JuridicalPersonEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method JuridicalPersonEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method JuridicalPersonEntity[]    findAll()
 * @method JuridicalPersonEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JuridicalPersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JuridicalPersonEntity::class);
    }
}
