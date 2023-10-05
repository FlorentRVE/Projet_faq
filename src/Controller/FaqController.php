<?php

namespace App\Controller;

use App\Entity\Demande;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DemandeRepository;

class FaqController extends AbstractController
{

    #[Route('/faq', name: 'app_faq')]
    public function getDemandes(DemandeRepository $demandeRepository, Request $request): Response
    {
        $demande = $demandeRepository->findAll(); // Récupération des données de la base

        $searchTerm = $request->query->get('search'); // Récupération de la valeur de la requête
        $data = []; // Donnée à afficher
        
        foreach($demande as $item) {
            
            // Si le terme de recherche est vide ou si la question ou réponse contient le terme de recherche
            // on ajoute l'objet à la liste à afficher
            if (empty($searchTerm) || stripos($item->getQuestion(), $searchTerm) !== false || stripos($item->getReponse(), $searchTerm) !== false) {
                $data[] = [
                    'Categorie' => $item->getCategorie(),
                    'Question' => $item->getQuestion(),
                    'Reponse' => $item->getReponse(),
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
