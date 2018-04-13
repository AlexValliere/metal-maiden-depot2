<?php

namespace App\Repository;

use App\Entity\AttireCategory;
use App\Entity\MetalMaiden;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MetalMaiden|null find($id, $lockMode = null, $lockVersion = null)
 * @method MetalMaiden|null findOneBy(array $criteria, array $orderBy = null)
 * @method MetalMaiden[]    findAll()
 * @method MetalMaiden[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MetalMaidenRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MetalMaiden::class);
    }

    public function findAllWithAttireCategories()
    {
      $qb = $this
        ->createQueryBuilder('m')
        ->leftJoin('m.attireCategory', 'a')
        ->addSelect('a')
      ;

      return $qb
        ->getQuery()
        ->getResult()
      ;
    }

    public function findOneByIdJoinedToAttireCategory($metalMaidenId)
    {
        return $this->createQueryBuilder('m')
            // m.attireCategory refers to the "attireCategory" property on metalMaiden
            ->innerJoin('m.attireCategory', 'a')
            // selects all the attireCategory data to avoid the query
            ->addSelect('a')
            ->andWhere('m.id = :id')
            ->setParameter('id', $metalMaidenId)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return MetalMaiden[] Returns an array of MetalMaiden objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MetalMaiden
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
