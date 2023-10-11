<?php

namespace App\Controller;

use App\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\QuestionRepository;

class FaqController extends AbstractController
{

    // =============== Controller de la partie utilisateur-only de la FAQ =========================

    // Seulement affichage et recherche des questions/réponses depuis la BDD

    #[Route('/faq', name: 'app_faq')]
    public function getQuestions(QuestionRepository $questionRepository, Request $request): Response
    {
        $question = $questionRepository->findAll(); // Récupération des données de la base

        $searchTerm = $request->query->get('search'); // Récupération de la valeur de la requête
        $data = []; // Donnée à afficher
        
        foreach($question as $item) {
            
            // Si le terme de recherche est vide ou si la question ou réponse contient le terme de recherche
            // on ajoute l'objet à la liste à afficher
            if (empty($searchTerm) || stripos($item->getLabel(), $searchTerm) !== false || stripos($item->getReponse(), $searchTerm) !== false) {
                
                $categorie = $item->getCategorie(); 
                $departement = $categorie->getDepartement();

                $data[] = [
                    'categorie' => $categorie,
                    'departement' => $departement->getLabel(),
                    'question' => $item->getLabel(),
                    'reponse' => $item->getReponse(),
                ];
            }
            
            
        }

        return $this->render('faq/index.html.twig', [
            'controller_name' => 'FaqController',
            'data' => $data,
            'searchTerm' => $searchTerm,

        ]);
    }
}
