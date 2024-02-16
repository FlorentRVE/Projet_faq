<?php

namespace App\Controller;

use App\Entity\Saisi;
use App\Form\SaisiType;
use App\Repository\SaisiRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/saisi')]
class SaisiController extends AbstractController
{
    #[Route('/', name: 'app_saisi_index', methods: ['GET'])]
    public function index(SaisiRepository $saisiRepository, Request $request): Response
    {        
        $searchTerm = $request->query->get('search');
        $sortTerm = $request->query->get('sort');
        $sortBy = $request->query->get('by');

        if($sortBy && $sortTerm){
            switch ($sortBy) {
                case 'collaborateur':
                    $saisi = $saisiRepository->sortSaisiFromCollaborateur($searchTerm, $sortTerm);
                    break;
                case 'motif':
                    $saisi = $saisiRepository->sortSaisiFromMotif($searchTerm, $sortTerm);
                    break;
                case 'typeDemande':
                    $saisi = $saisiRepository->sortSaisiFromTypeDemande($searchTerm, $sortTerm);
                    break;
                case 'service':
                    $saisi = $saisiRepository->sortSaisiFromService($searchTerm, $sortTerm);
                    break;
                default:
                    $saisi = $saisiRepository->sortSaisiFromSearch($searchTerm, $sortTerm, $sortBy);
                    break;
            }
        } else {
            $saisi = $saisiRepository->getSaisiFromSearch($searchTerm);
        }

        return $this->render('saisi/index.html.twig', [
            'saisis' => $saisi,
            'searchTerm' => $searchTerm
        ]);
    }

        #[Route('/cityker', name: 'app_saisi_cityker', methods: ['GET'])]
    public function cityker(SaisiRepository $saisiRepository, Request $request): Response
    {        
        $searchTerm = $request->query->get('search');

        $saisi = $saisiRepository->getCitykerFromSearch($searchTerm);

        return $this->render('saisi/index.html.twig', [
            'saisis' => $saisi,
            'searchTerm' => $searchTerm
        ]);
    }
        #[Route('/vae', name: 'app_saisi_vae', methods: ['GET'])]
    public function vae(SaisiRepository $saisiRepository, Request $request): Response
    {        
        $searchTerm = $request->query->get('search');

        $saisi = $saisiRepository->getVaeFromSearch($searchTerm);

        return $this->render('saisi/index.html.twig', [
            'saisis' => $saisi,
            'searchTerm' => $searchTerm
        ]);
    }

    #[Route('/new', name: 'app_saisi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
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

            return $this->redirectToRoute('app_saisi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('saisi/new.html.twig', [
            'saisi' => $saisi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_saisi_show', methods: ['GET'])]
    public function show(Saisi $saisi): Response
    {
        return $this->render('saisi/show.html.twig', [
            'saisi' => $saisi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_saisi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Saisi $saisi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SaisiType::class, $saisi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_saisi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('saisi/edit.html.twig', [
            'saisi' => $saisi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_saisi_delete', methods: ['POST'])]
    public function delete(Request $request, Saisi $saisi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $saisi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($saisi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_saisi_index', [], Response::HTTP_SEE_OTHER);
    }
}
