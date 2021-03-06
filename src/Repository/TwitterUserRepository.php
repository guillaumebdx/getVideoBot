<?php

namespace App\Repository;

use App\Entity\TwitterUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TwitterUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TwitterUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TwitterUser[]    findAll()
 * @method TwitterUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwitterUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TwitterUser::class);
    }

    public function userExist(string $username)
    {
        return (bool)$this->findOneBy(['username' => $username]);
    }
    // /**
    //  * @return TwitterUser[] Returns an array of TwitterUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TwitterUser
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
