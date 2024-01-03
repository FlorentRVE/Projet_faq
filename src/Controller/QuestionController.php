<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\DepartementRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('/question')]
class QuestionController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // ======================== Controller de la partie administration de la FAQ =========================

    // CRUD généré automatiquement à partir de l'entité Question par "make:crud Question"
    // Les templates TWIG correspondants on été generés automatiquement et personnalisé par la suite 


    // ============== Panneau d'administration avec affichage de toutes les questions =============================

    #[Route('/', name: 'app_question_index', methods: ['GET'])]
    public function index(DepartementRepository $departementRepository, Request $request): Response
    {

        //Récupération de l'utilisateur authentifié
        $user = $this->security->getUser()->getUserIdentifier();

        //Récupération de la valeur de la requête
        $searchTerm = $request->query->get('search'); 
        
        // Récupération des questions filtré par la recherche et le departement de l'utilisateur authentifié
        $data = $departementRepository->getQuestionsFromSearchAndUser($searchTerm, $user);
        // dd($data);

        return $this->render('question/index.html.twig', [
            'data' => $data,
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
        if ($this->isCsrfTokenValid('delete' . $question->getId(), $request->request->get('_token'))) {
            $entityManager->remove($question);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
    }

    ///////////////////////////

    #[Route('/{id}/count', name: 'app_question_count', methods: ['POST'])]
    public function counter(QuestionRepository $questionRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $question = $questionRepository->find($id);
        $question->setCount($question->getCount() + 1);
        $entityManager->flush();

        return new Response('Counted!', 200);

    }
}
