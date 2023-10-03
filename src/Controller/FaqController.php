<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(Request $request): Response
    {
        $faqList = [

            $id_1 = [
                'catégorie' => 'city_ker',
                'question' => 'question_city_ker_1tttttttttttttttttttt',
                'reponse' => 'reponse_city_ker_1'
            ],

            $id_2 = [
                'catégorie' => 'velo',
                'question' => 'question_velo_1',
                'reponse' => 'reponse_vélo_1 bla leefegrhri gtrgtg tgtgt gtghtug tgtgt gt gtgtgtrgotguierhg e gegegerger gergoerughre g lorem ipsum frghire fefejifgegeziuyfgfgzyef fheufe fhegf efgeulfhefefef'
            ],

            $id_3 = [
                'catégorie' => 'vert',
                'question' => 'question_vert_1',
                'reponse' => 'reponse_vert_1'
            ],

            $id_4 = [
                'catégorie' => 'city_ker',
                'question' => 'question_city_ker_2tttttttttttttttttttt',
                'reponse' => 'reponse_city_ker_2'
            ],

            $id_5 = [
                'catégorie' => 'velo',
                'question' => 'question_velo_2',
                'reponse' => 'reponse_vélo_2'
            ],

            $id_6 = [
                'catégorie' => 'vert',
                'question' => 'question_vert_2',
                'reponse' => 'reponse_vert_2'
            ],

            $id_7 = [
                'catégorie' => 'city_ker',
                'question' => 'question_city_ker_3tttttttttttttttttttt',
                'reponse' => 'reponse_city_ker_3'
            ],

            $id_8 = [
                'catégorie' => 'velo',
                'question' => 'question_velo_3',
                'reponse' => 'reponse_vélo_3'
            ],

            $id_9 = [
                'catégorie' => 'vert',
                'question' => 'question_vert_3',
                'reponse' => 'reponse_vert_3'
            ]

        ];

        $searchTerm = $request->query->get('search');
        $data = [];
        
        foreach($faqList as $item) {
            
            // Si le terme de recherche est vide ou si la question ou réponse contient le terme de recherche
            // on ajoute l'objet à la liste à afficher
            if (empty($searchTerm) || stripos($item['question'], $searchTerm) !== false || stripos($item['reponse'], $searchTerm) !== false) {
                $data[] = [
                    'Categorie' => $item['catégorie'],
                    'Question' => $item['question'],
                    'Reponse' => $item['reponse'],
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
