<?php

namespace App\Repository;

use App\Entity\Question;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Question>
 *
 * @method Question|null find($id, $lockMode = null, $lockVersion = null)
 * @method Question|null findOneBy(array $criteria, array $orderBy = null)
 * @method Question[]    findAll()
 * @method Question[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Question::class);
    }

    // Requête permettant de récupérer les données de la base en fonction d'un terme de recherche et des départements auxquels
    // appartient l'utilisateur authentifié
    public function getQuestionsFromSearchAndUser($searchTerm, $user) {

        return $this->createQueryBuilder('q') // jusqu'à les questions 

        ->select('q, c, d')
        ->innerJoin('q.categorie', 'c') // ... en passant par les catégories
        ->innerJoin('c.departement', 'd')
        ->innerJoin('d.users', 'u') // ... on remonte depuis le departement
        ->andWhere('u.email = :users') // ... et l'identité de l'utilisateur authentifié
        ->andwhere(':searchTerm = \'\' OR 
            q.label LIKE :searchTerm OR 
            q.reponse LIKE :searchTerm') // ... ensuite selon le terme de recherche
        ->setParameter('users', $user) // ici on a besoin de l'utilisateur authentifie (user) et de la valeur de la requête (searchTerm) ...
        ->setParameter('searchTerm', '%'.$searchTerm.'%') // On commence par déclarer les variables dynamiques qui seront utilisées dans notre requête ...
        ->getQuery()
        ->getResult();
    }

    // Requête permettant de récupérer les données de la base en fonction d'un terme de recherche
    public function getQuestionsFromSearch($searchTerm) {

        return $this->createQueryBuilder('q')

        ->select('q, c, d')
        ->innerJoin('q.categorie', 'c')
        ->innerJoin('c.departement', 'd')
        ->where(':searchTerm = \'\' OR 
              q.label LIKE :searchTerm OR 
              q.reponse LIKE :searchTerm')
        ->setParameter('searchTerm', '%'.$searchTerm.'%')
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return Question[] Returns an array of Question objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Question
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
