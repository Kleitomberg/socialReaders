<?php

namespace App\Repository;

use App\Entity\Conversa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;

/**
 * @extends ServiceEntityRepository<Conversa>
 *
 * @method Conversa|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversa|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversa[]    findAll()
 * @method Conversa[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversa::class);
    }

    public function add(Conversa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Conversa $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Conversa[] Returns an array of Conversa objects
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

//    public function findOneBySomeField($value): ?Conversa
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function findConversationByParticipants(int $otherUserId, int $myId)
{
    $qb = $this->createQueryBuilder('c');
    $qb
        ->select($qb->expr()->count('p.conversa'))
        ->innerJoin('c.participantes', 'p')
        ->where(
            $qb->expr()->orX(
                $qb->expr()->eq('p.usuario', ':me'),
                $qb->expr()->eq('p.usuario', ':otherUser')
            )
        )
        ->groupBy('p.conversa')
        ->having(
            $qb->expr()->eq(
                $qb->expr()->count('p.conversa'),
                2
            )
        )
        ->setParameters([
            'me' => $myId,
            'otherUser' => $otherUserId
        ])
    ;

    return $qb->getQuery()->getResult();
}

public function findConversationsByUser(int $userId)
    {
        $qb = $this->createQueryBuilder('c');
        $qb->
            select('otherUser.nome', 'c.id as conversaId', 'lm.conteudo', 'lm.criadoEm')
            ->innerJoin('c.participantes', 'p', Join::WITH, $qb->expr()->neq('p.usuario', ':usuario'))
            ->innerJoin('c.participantes', 'me', Join::WITH, $qb->expr()->eq('me.usuario', ':usuario'))
            ->leftJoin('c.ultimaMensagem', 'lm')
            ->innerJoin('me.usuario', 'meUser')
            ->innerJoin('p.usuario', 'otherUser')
            ->where('meUser.id = :usuario')
            ->setParameter('usuario', $userId)
            ->orderBy('lm.criadoEm', 'DESC')
        ;

        return $qb->getQuery()->getResult();
    }


}
