<?php

namespace App\Person\Repository;

use App\Person\DTO\PersonSearchDTO;
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

    public function search(PersonSearchDTO $search): array
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p, pi, addresses, pj')
            ->leftJoin('p.individualPerson', 'pi')
            ->leftJoin('p.addresses', 'addresses')
            ->leftJoin('p.juridicalPerson', 'pj')
        ;
//        if ($search->IsIndividual()) {
//            $qb->andWhere('pi.id is not null');
//        }
//        else{
//            $qb->andWhere('pj.id is not null');
//        }
        return $qb->getQuery()->getResult();
    }
}
