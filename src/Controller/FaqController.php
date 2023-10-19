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

        $searchTerm = $request->query->get('search'); // Récupération de la valeur de la requête

        $question = $questionRepository->getQuestionsFromSearch($searchTerm);
        $data = []; // Donnée à afficher
        
        foreach($question as $item) {

                $data[] = [
                    'categorie' => $item->getCategorie()->getLabel(),
                    'departement' => $item->getCategorie()->getDepartement()->getLabel(),
                    'question' => $item->getLabel(),
                    'reponse' => $item->getReponse(),
                ];           
            
        }

        return $this->render('faq/index.html.twig', [
            'controller_name' => 'FaqController',
            'data' => $data,
            'searchTerm' => $searchTerm,

        ]);
    }
}
