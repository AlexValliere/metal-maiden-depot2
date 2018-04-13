<?php

namespace App\Repository;

use App\Entity\AttireCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AttireCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttireCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttireCategory[]    findAll()
 * @method AttireCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttireCategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttireCategory::class);
    }

//    /**
//     * @return AttireCategory[] Returns an array of AttireCategory objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttireCategory
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
