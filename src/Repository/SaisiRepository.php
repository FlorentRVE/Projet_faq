<?php

namespace App\Repository;

use App\Entity\Saisi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Saisi>
 *
 * @method Saisi|null find($id, $lockMode = null, $lockVersion = null)
 * @method Saisi|null findOneBy(array $criteria, array $orderBy = null)
 * @method Saisi[]    findAll()
 * @method Saisi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaisiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saisi::class);
    }

    public function getSaisiFromSearch($searchTerm)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->innerJoin('s.service', 'd')
        ->where(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                d.label LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->getQuery()
        ->getResult();
    }
    public function getCitykerFromSearch($searchTerm)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->innerJoin('s.service', 'd')
        ->andWhere('d.label = \'Cityker\'')
        ->andWhere(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                d.label LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->getQuery()
        ->getResult();
    }
    public function getVaeFromSearch($searchTerm)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->innerJoin('s.service', 'd')
        ->andWhere('d.label = \'Numéro vert\'')
        ->andWhere(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                d.label LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->getQuery()
        ->getResult();
    }

    public function sortSaisiFromSearch($searchTerm, $sortTerm, $sortBy)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->where(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->orderBy("s.".$sortBy."", $sortTerm)
        ->getQuery()
        ->getResult();
    }

        public function sortSaisiFromCollaborateur($searchTerm, $sortTerm)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->where(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->orderBy('c.email', $sortTerm)
        ->getQuery()
        ->getResult();
    }

    public function sortSaisiFromMotif($searchTerm, $sortTerm)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->where(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->orderBy('m.label', $sortTerm)
        ->getQuery()
        ->getResult();
    }

    public function sortSaisiFromTypeDemande($searchTerm, $sortTerm)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->where(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->orderBy('t.label', $sortTerm)
        ->getQuery()
        ->getResult();
    }
    public function sortSaisiFromService($searchTerm, $sortTerm)
    {

        return $this->createQueryBuilder('s')

        ->select('s')
        ->innerJoin('s.motif', 'm')
        ->innerJoin('s.typeDemande', 't')
        ->innerJoin('s.collaborateur', 'c')
        ->innerJoin('s.service', 'd')
        ->where(':searchTerm = \'\' OR 
                s.nom LIKE :searchTerm OR
                s.prenom LIKE :searchTerm OR
                s.commentaire LIKE :searchTerm OR
                m.label LIKE :searchTerm OR
                t.label LIKE :searchTerm OR
                c.email LIKE :searchTerm OR
                d.label LIKE :searchTerm OR
                s.telephone LIKE :searchTerm')
        ->setParameter('searchTerm', '%' . $searchTerm . '%')
        ->orderBy('d.label', $sortTerm)
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Saisi[] Returns an array of Saisi objects
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

    //    public function findOneBySomeField($value): ?Saisi
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
