<?php

namespace App\Controller;

use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class FaqController extends AbstractController
{

    // =============== Controller de la page principale de la FAQ =========================

    #[Route('/', name: 'app_home')]
    public function home()
    {
        return $this -> redirectToRoute('app_faq', [], Response::HTTP_SEE_OTHER);
    }

    // Seulement affichage et recherche des questions/réponses depuis la BDD

    #[Route('/faq', name: 'app_faq')]
    public function getQuestions(Request $request, DepartementRepository $departementRepository): Response
    {

        // Récupération de la valeur de la recherche
        $searchTerm = $request->query->get('search');

        // On récupére les données de la base en fonction de la recherche
        $data = $departementRepository->getQuestionsFromSearch($searchTerm);      

        return $this->render('faq/index.html.twig', [
            'controller_name' => 'FaqController',
            'data' => $data,
            'searchTerm' => $searchTerm,

        ]);
    }
}
