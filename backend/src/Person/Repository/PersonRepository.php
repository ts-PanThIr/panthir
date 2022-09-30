<?php

namespace App\Person\Repository;

use App\Person\Entity\PersonEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PersonEntity>
 *
 * @method PersonEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method PersonEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method PersonEntity[]    findAll()
 * @method PersonEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonEntity::class);
    }

    public function add(PersonEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PersonEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
