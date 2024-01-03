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

#[Route('/count', name: 'app_question_count')]
class CountController extends AbstractController
{
    #[Route('/{id}', name: 'app_question_counter', methods: ['POST'])]
    public function counter(QuestionRepository $questionRepository, EntityManagerInterface $entityManager, $id): Response
    {
        $question = $questionRepository->find($id);
        $question->setCount($question->getCount() + 1);
        $entityManager->flush();

        return new Response('Counted!', 200);

    }
}