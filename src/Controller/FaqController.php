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

    #[Route('/createdemande', name: 'create_demande')]
    public function createDemande(EntityManagerInterface $entityManager): Response
    {
        $demande = new Demande();
        $demande->setQuestion('Qu"elles sont les horaires de City Ker ?');
        $demande->setRéponse('Les horaires sont de 9h30 à 18h30');
        $demande->setCatégorie('city_ker');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($demande);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Nouvelle demande créee '.$demande->getId());
    }


    #[Route('/faq', name: 'app_faq')]
    public function getDemandes(DemandeRepository $demandeRepository, Request $request): Response
    {
        $demande = $demandeRepository->findAll(); // Récupération des données de la base

        $searchTerm = $request->query->get('search'); // Récupération de la valeur de la requête
        $data = []; // Donnée à afficher
        
        foreach($demande as $item) {
            
            // Si le terme de recherche est vide ou si la question ou réponse contient le terme de recherche
            // on ajoute l'objet à la liste à afficher
            if (empty($searchTerm) || stripos($item->getQuestion(), $searchTerm) !== false || stripos($item->getRéponse(), $searchTerm) !== false) {
                $data[] = [
                    'Categorie' => $item->getCatégorie(),
                    'Question' => $item->getQuestion(),
                    'Reponse' => $item->getRéponse(),
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
