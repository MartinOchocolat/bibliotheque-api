<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/livres')]
final class LivreController extends AbstractController
{
    #[Route('', name: 'livre_liste')]
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

    #[Route('', name: 'livre_creation', methods: ['POST'])]
    public function creation(
        Request $request,
        DenormalizableInterface $denormalizer,
        ValidatorInterface $validator,
        AuteurRepository $auteurRepository,
        EntityManagerInterface $em

    ): JsonResponse {
        $donnees = $request->toArray();

        try {
            $livre = $denormalizer->denormalize($donnees, Livre::class, null, ['groups' => 'livre:ecriture']);
        } catch (NotNormalizableValueException $e) {
            return $this->json(['erreur' => $e->getMessage()], 400);
        }

        $livre->setAuteur($auteurRepository->find($donnees['auteurId'] ?? 0));

        //Validation
        $erreurs = $validator->validate($livre);
        if (count($erreurs) > 0) {
            return $this->json($erreurs, 422);
        }

        // Enregistrer en base
    }
}