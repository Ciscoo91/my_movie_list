<?php

namespace App\Repository;

use App\Entity\MovieList;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method MovieList|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieList|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieList[]    findAll()
 * @method MovieList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieListRepository extends ServiceEntityRepository
{
    protected $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, MovieList::class);
    }

    public function FindByIdAndDelete($id)
    {
        $movie = $this->find($id);
        $this->em->delete($movie);
        $this->em->flush();
    }

    // /**
    //  * @return MovieList[] Returns an array of MovieList objects
    //  */
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
    public function findOneBySomeField($value): ?MovieList
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
