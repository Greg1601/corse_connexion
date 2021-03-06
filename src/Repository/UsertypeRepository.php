<?php

namespace App\Repository;

use App\Entity\Usertype;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Usertype|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usertype|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usertype[]    findAll()
 * @method Usertype[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsertypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Usertype::class);
    }

//    /**
//     * @return Usertype[] Returns an array of Usertype objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usertype
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
