<?php

namespace App\Controller;

use App\Entity\Saisi;
use App\Form\SaisiType;
use App\Repository\DepartementRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function getQuestions(Request $request, DepartementRepository $departementRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        
        // ======== MODAL FORM ================
        if ($this->getUser()) {
            
            $user = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
            $services = $user->getDepartement();
            
            $saisi = new Saisi();
            $form = $this->createForm(SaisiType::class, $saisi);
            $form->handleRequest($request);
            $saisi->setCollaborateur($user);
            $saisi->setDate(new \DateTimeImmutable());
            $saisi->setHeure(new \DateTimeImmutable());
            
            foreach($services as $service) {
                $saisi->addService($service);
            }
            
            
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($saisi);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_faq', [], Response::HTTP_SEE_OTHER);
            }
            // ============================
            
            // Récupération de la valeur de la recherche
            $searchTerm = $request->query->get('search');
            
            // On récupére les données de la base en fonction de la recherche
            $data = $departementRepository->getQuestionsFromSearch($searchTerm);      
            
            return $this->render('faq/index.html.twig', [
                'controller_name' => 'FaqController',
                'data' => $data,
                'searchTerm' => $searchTerm,
                'form' => $form,
                
            ]);

        } else {
            
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
}
