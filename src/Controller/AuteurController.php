<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/auteur')]
final class AuteurController extends AbstractController
{
    #[Route('', name: 'auteur_index', methods: ['GET'])]
    public function index(AuteurRepository $auteurRepository): JsonResponse
    {
        return $this->json($auteurRepository->findAll(), 200, [], ['groups' => 'livre:lecture']);
    }

    #[Route('/{id}', name: 'auteur_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id, AuteurRepository $auteurRepository): JsonResponse
    {
        $auteur = $auteurRepository->find($id);

        if (null === $auteur) {
            return $this->json(['erreur' => 'Auteur introuvable'], 404);
        }

        return $this->json($auteur, 200, [], ['groups' => 'livre:lecture']);
    }

    #[Route('/{id}/livres', name: 'auteur_livres', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function livres(int $id, AuteurRepository $auteurRepository): JsonResponse
    {
        $auteur = $auteurRepository->find($id);

        if (null === $auteur) {
            return $this->json(['erreur' => 'Auteur introuvable'], 404);
        }

        return $this->json($auteur->getLivres());
    }

}