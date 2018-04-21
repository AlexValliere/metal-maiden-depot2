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

    public function findAllWithJoin()
    {
        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->leftJoin('m.attireCategory', 'a')
            ->addSelect('a')
            ->leftJoin('m.nation', 'n')
            ->addSelect('n')
        ;

        $queryBuilder->addOrderBy('m.attire', 'ASC');

        return $queryBuilder
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllByAttireCategoryAbbreviationOrNationName($options = [])
    {

        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->leftJoin('m.attireCategory', 'a')
            ->addSelect('a')
            ->leftJoin('m.nation', 'n')
            ->addSelect('n');

        if ( !empty($options['attire_category_abbreviation']) )
        {
            $queryBuilder
                ->andWhere('a.abbreviation = :attire_category_abbreviation')
                ->setParameter('attire_category_abbreviation', $options['attire_category_abbreviation']);
        }
        if ( !empty($options['nation_name']) )
        {
            $queryBuilder
                ->andWhere('n.name = :nation_name')
                ->setParameter('nation_name', $options['nation_name']);
        }

        $queryBuilder->addOrderBy('m.attireCategory', 'ASC');
        $queryBuilder->addOrderBy('m.attire', 'ASC');

        return $queryBuilder
            ->getQuery()
            ->getResult();
        ;
    }

    public function findByAttireCategoryOrNation($options = [])
    {

        $queryBuilder = $this
            ->createQueryBuilder('m')
            ->leftJoin('m.attireCategory', 'a')
            ->addSelect('a')
            ->leftJoin('m.nation', 'n')
            ->addSelect('n');

        if ( array_key_exists('attire_category_abbreviation', $options) )
        {
            $queryBuilder
                ->andWhere('a.abbreviation = :attire_category_abbreviation')
                ->setParameter('attire_category_abbreviation', $options['attire_category_abbreviation']);
        }
        if ( array_key_exists('nation_name', $options) )
        {
            $queryBuilder
                ->andWhere('n.name = :nation_name')
                ->setParameter('nation_name', $options['nation_name']);
        }

        $queryBuilder->addOrderBy('m.attireCategory', 'ASC');
        $queryBuilder->addOrderBy('m.attire', 'ASC');

        return $queryBuilder
            ->getQuery()
            ->getResult();
        ;
    }

    public function findByAttireCategoryWithAttireCategoriesAndNations($attireCategoryAbbreviation)
    {
      $qb = $this
        ->createQueryBuilder('m')
        ->leftJoin('m.attireCategory', 'a')
        ->addSelect('a')
        ->leftJoin('m.nation', 'n')
        ->addSelect('n')
        ->andWhere('a.abbreviation = :attire_category_abbreviation')
        ->setParameter('attire_category_abbreviation', $attireCategoryAbbreviation)
        ->orderBy('m.attire', 'ASC')
      ;

      return $qb
        ->getQuery()
        ->getResult();
      ;
    }

    public function findByNationWithAttireCategoriesAndNations($nationName)
    {
      $qb = $this
        ->createQueryBuilder('m')
        ->leftJoin('m.attireCategory', 'a')
        ->addSelect('a')
        ->leftJoin('m.nation', 'n')
        ->addSelect('n')
        ->andWhere('n.name = :nation_name')
        ->setParameter('nation_name', $nationName)
        ->orderBy('m.attireCategory', 'ASC')
      ;

      return $qb
        ->getQuery()
        ->getResult();
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
