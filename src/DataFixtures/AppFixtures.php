<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $livres = [
            ['Les Misérables', '1097539193923', 1862, 'Le destin de Jean Valjean dans la France du XIX siècle.'],
            ['1984', '9780451524935', 1949, 'Un roman dystopique sur un régime totalitaire.'],
            ['Le Petit Prince', '9780156012195', 1943, null]
        ];

        foreach ($livres as [$titre, $isbn, $annee, $resume]) {
            $livre = (new Livre())
            ->setTitre($titre)
            ->setIsbn($isbn)
            ->setAnneePublication($annee)
            ->setResume($resume);

            $manager->persist($livre);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
