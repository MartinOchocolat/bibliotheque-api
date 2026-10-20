<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/livres')]

final class LivreController extends AbstractController
{
    #[Route('', name: 'livre_liste', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): JsonResponse
    {
        return $this->json($livreRepository->findAll());
    }

    #[Route('/{id}', name: 'livre_detail', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function detail(int $id, LivreRepository $livreRepository): JsonResponse
    {
        $livre = $livreRepository->find($id);

        if (null === $livre) {
            return $this->json(['erreur' => 'Livre introuvable'], 404);
        }

        return $this->json($livre);
    }
}
