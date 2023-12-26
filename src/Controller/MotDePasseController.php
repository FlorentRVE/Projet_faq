<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\MotDePasseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/mot_de_passe')]
class MotDePasseController extends AbstractController
{
    #[Route('/{id}/changer', name: 'app_mot_de_passe_changer', methods: ['GET', 'POST'])]
    public function changerMotDePasse(Request $request, User $user, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $form = $this->createForm(MotDePasseType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $currentUserId = $this->getUser()->getId();
            $userId = $user->getId();

            if ($currentUserId !== $userId) {

                throw new \Exception('Vous ne pouvez pas changer le mot de passe de ce compte');

            } else {

                $user->setPassword(
                    $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
                $entityManager->flush();

                return $this->redirectToRoute('app_question_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('user/motDePasse.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
