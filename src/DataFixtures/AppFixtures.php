<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Auteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public $genre_ref = 'genre';
    public $auteur_ref = 'auteur';

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i <= 20; $i++) {
            $auteur = new Auteur();
            $auteur->setNomPrenom($faker->firstName . ' ' . $faker->lastName);
            $auteur->setSexe($faker->randomElement(['f', 'm']));
            $auteur->setDateDeNaissance(new \DateTime($faker->date()));
            $auteur->setNationalite($faker->countryCode);
            $manager->persist($auteur);
            $this->addReference($this->auteur_ref . '-' . $i, $auteur);
        }

        for ($i = 0; $i <= 10; $i++) {
            $genre = (new Genre())->setNom($faker->word());
            $manager->persist($genre);
            $this->addReference($this->genre_ref . '-' . $i, $genre);
        }


        for ($i = 0; $i <= 50; $i++) {
            $livre = new Livre();
            $livre->setIsbn($faker->isbn13);
            $livre->setTitre($faker->words($faker->numberBetween(1, 3), true));
            $livre->setNombrePages($faker->numberBetween(10, 500));
            $livre->setDateDeParution(new \DateTime($faker->dateTimeBetween("01-01-1900", "01-01-2022")->format('Y-m-d')));
            $livre->setNote($faker->numberBetween(0, 20));

            for ($j = 0; $j < $faker->numberBetween(1, 3); $j++) {
                $livre->addAuteur($this->getReference($this->auteur_ref . '-' . $faker->numberBetween(0, 20)));
                $livre->addGenre($this->getReference($this->genre_ref . '-' . $faker->numberBetween(0, 10)));
            }
            $manager->persist($livre);
        }

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin1234'
        ));
        $admin->setRoles(["ROLE_ADMIN"]);
        $manager->persist($admin);

        $manager->flush();
    }
}
