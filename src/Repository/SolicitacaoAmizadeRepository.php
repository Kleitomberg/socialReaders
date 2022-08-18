<?php

namespace App\Repository;

use App\Entity\SolicitacaoAmizade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SolicitacaoAmizade>
 *
 * @method SolicitacaoAmizade|null find($id, $lockMode = null, $lockVersion = null)
 * @method SolicitacaoAmizade|null findOneBy(array $criteria, array $orderBy = null)
 * @method SolicitacaoAmizade[]    findAll()
 * @method SolicitacaoAmizade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SolicitacaoAmizadeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SolicitacaoAmizade::class);
    }

    public function add(SolicitacaoAmizade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SolicitacaoAmizade $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SolicitacaoAmizade[] Returns an array of SolicitacaoAmizade objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SolicitacaoAmizade
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }


}
