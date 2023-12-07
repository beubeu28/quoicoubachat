<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function filtre($recherche, $Type, $Univers, $PMin, $PMax, $Prix): array
    {
        $queryBuilder = $this->createQueryBuilder('c');

        if ($PMin){
            $queryBuilder->andWhere('c.prix >= :min')
                ->setParameter('min', $PMin);
        }
        if ($PMax){
            $queryBuilder->andWhere('c.prix <= :max')
                ->setParameter('max', $PMax);
        }
        if ($Prix !== '0'){
            $queryBuilder->orderBy('c.prix', $Prix);
        }
        if ($Type !== '0') {
            $queryBuilder->andWhere('c.description LIKE :type')
                ->setParameter('type', '%' . $Type . '%');
        }
        if ($Univers !== '0') {
            $queryBuilder->andWhere('c.description LIKE :univers')
                ->setParameter('univers', '%' . $Univers . '%');
        }
        if ($recherche) {
            $queryBuilder->andWhere('c.description LIKE :recherche')
                ->setParameter('recherche', '%' . $recherche . '%');
        }
        $query = $queryBuilder->getQuery();
        return $query->getResult();
    }

    
//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
