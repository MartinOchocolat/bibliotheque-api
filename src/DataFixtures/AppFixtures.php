<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $hugo = new Auteur();
        $hugo->setNom('Victor Hugo');
        $manager->persist($hugo);

        $orwell = new Auteur();
        $orwell->setNom('George Orwell');
        $manager->persist($orwell);

        $exupery = new Auteur();
        $exupery->setNom('Antoine de Saint-Exupéry');
        $manager->persist($exupery);

        $livres = [
            ['Les Misérables', '2748382838382', 1862, 'Le destin de Jean Valjean dans la France du XIX siècle.', $hugo],
            ['1984', '9780451524935', 1949, 'Un roman dystopique sur un régime totalitaire.', $orwell],
            ['Le Petit Prince', '9780156012195', 1943, 'Une histoire poétique et philosophique sur l\'amitié et la vie.', $exupery],
        ];

        foreach ($livres as [$titre, $isbn, $anneePublication, $resume, $auteur]) {
            $livre = (new Livre())
                ->setTitre($titre)
                ->setIsbn($isbn)
                ->setAnneePublication($anneePublication)
                ->setResume($resume)
                ->setAuteur($auteur);

            $manager->persist($livre);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
