<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/question')]
class QuestionController extends AbstractController
{

    // ======================== Controller de la partie administrateur de la FAQ =========================

    // CRUD généré automatiquement à partir de l'entité Demande par "make:crud Question"
    // Les templates TWIG correspondants on été generés automatiquement et personnalisé par la suite 


    // ============== Panneau d'administration avec affichage de toutes les questions =============================

    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository, Request $request): Response
    {

        $question = $questionRepository->findAll(); // Récupération des données de la base

        $searchTerm = $request->query->get('search'); // Récupération de la valeur de la requête
        $data = []; // Donnée à afficher
        
        foreach($question as $item) {
            
            // Si le terme de recherche est vide OU si la question/réponse contient le terme de recherche
            // on ajoute l'objet à la liste à afficher
            if (empty($searchTerm) || stripos($item->getLabel(), $searchTerm) !== false || stripos($item->getReponse(), $searchTerm) !== false) {

                $categorie = $item->getCategorie(); 
                $departement = $categorie->getDepartement();

                $data[] = [
                    'id' => $item->getId(),
                    'categorie' => $item->getCategorie(),
                    'departement' => $departement->getLabel(),
                    'label' => $item->getLabel(),
                    'reponse' => $item->getReponse(),
                ];
            }
            
            
        }

        return $this->render('question/index.html.twig', [
            'questions' => $data,
            'searchTerm' => $searchTerm,
        ]);
    }

     // =============== Création d'une nouvelle demande =========================
    #[Route('/new', name: 'app_question_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    // =============== Affichage d'une demande selon ID =========================
    #[Route('/{id}', name: 'app_question_show', methods: ['GET'])]
    public function show(Question $question): Response
    {
        return $this->render('question/show.html.twig', [
            'question' => $question,
        ]);
    }

    // =============== Modification d'une demande selon ID =========================
    #[Route('/{id}/edit', name: 'app_question_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    // =============== Suppression d'une demande selon ID =========================
    #[Route('/{id}', name: 'app_question_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }
}
