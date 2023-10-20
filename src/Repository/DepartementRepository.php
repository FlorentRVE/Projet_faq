<?php

namespace App\Repository;

use App\Entity\Departement;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Departement>
 *
 * @method Departement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Departement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Departement[]    findAll()
 * @method Departement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DepartementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Departement::class);
    }

    // =========== Requête permettant de récupérer les departements de l'utilisateur via son identifiant  =============
    // /!\ Ici on a volontairement omis getQuery et getResult pour ne pas créer une erreur dans QuestionType.php
    // penser à les rajouter si utiliser dans un controller
    public function getUserDepartments($user)
    {
        return $this->createQueryBuilder('d')
            ->innerJoin('d.users', 'u')
            ->andWhere('u.email = :users')
            ->setParameter('users', $user);
    }

    // =========== Requête permettant de récupérer les données de la base en fonction d'un terme de recherche =============
    public function getQuestionsFromSearch($searchTerm) {

        return $this->createQueryBuilder('d')

        ->select('q, c, d')
        ->innerJoin('d.categories', 'c')
        ->innerJoin('c.questions', 'q')
        ->where(':searchTerm = \'\' OR 
                q.label LIKE :searchTerm OR 
                q.reponse LIKE :searchTerm')
        ->setParameter('searchTerm', '%'.$searchTerm.'%')
        ->getQuery()
        ->getResult();
    }

    //    /**
    //     * @return Departement[] Returns an array of Departement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Departement
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
