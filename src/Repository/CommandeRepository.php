<?php

namespace App\Repository;

use App\Entity\Commande;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function findCurrentCommandeByUser(User $user): ?Commande
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.utilisateurid = :user')
        ->andWhere('c.statut = :statut')
        ->setParameter('user', $user)
        ->setParameter('statut', 'En cours')
        ->getQuery()
        ->getOneOrNullResult()
    ;
}
public function findCurrentCommandeById(int $id): ?Commande
{
    return $this->createQueryBuilder('c')
        ->andWhere('c.utilisateurid = :id')
        ->andWhere('c.statut = :statut')
        ->setParameter('id', $id)
        ->setParameter('statut', 'En cours')
        ->getQuery()
        ->getOneOrNullResult()
    ;
}
    public function findUser(int $id): ?Commande
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.utilisateurid = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }



//    /**
//     * @return Commande[] Returns an array of Commande objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commande
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
