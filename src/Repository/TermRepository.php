<?php

namespace App\Repository;

use App\Entity\Term;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Term|null find($id, $lockMode = null, $lockVersion = null)
 * @method Term|null findOneBy(array $criteria, array $orderBy = null)
 * @method Term[]    findAll()
 * @method Term[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TermRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Term::class);
    }

    // /**
    //  * @return Term[] Returns an array of Term objects
    //  */

    public function findJoin()
    {
        return $this->createQueryBuilder('t')
            ->select('t','c')
            ->leftJoin('t.category', 'c')
            ->orderBy('t.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
  

    /*
    public function findOneBySomeField($value): ?Term
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
