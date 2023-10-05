<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\Demande1Type;
use App\Repository\DemandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demande')]
class DemandeController extends AbstractController
{
    #[Route('/', name: 'app_demande_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository, Request $request): Response
    {
        $demande = $demandeRepository->findAll(); // Récupération des données de la base

        $searchTerm = $request->query->get('search'); // Récupération de la valeur de la requête
        $data = []; // Donnée à afficher
        
        foreach($demande as $item) {
            
            // Si le terme de recherche est vide OU si la question/réponse contient le terme de recherche
            // on ajoute l'objet à la liste à afficher
            if (empty($searchTerm) || stripos($item->getQuestion(), $searchTerm) !== false || stripos($item->getReponse(), $searchTerm) !== false) {
                $data[] = [
                    'id' => $item->getId(),
                    'Categorie' => $item->getCategorie(),
                    'Question' => $item->getQuestion(),
                    'Reponse' => $item->getReponse(),
                ];
            }
            
            
        }

        return $this->render('demande/index.html.twig', [
            'demandes' => $data,
            'searchTerm' => $searchTerm,
        ]);
    }

    #[Route('/new', name: 'app_demande_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demande = new Demande();
        $form = $this->createForm(Demande1Type::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demande);
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/new.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('demande/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demande_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Demande1Type::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('demande/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }
}
