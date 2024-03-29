<?php

namespace App\DataFixtures;

// import entity
use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Livre;
use App\Entity\Genre;
use App\Entity\Emprunteur;
use App\Entity\User;

use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Faker\Generator as FakerGenerator;

class TestFixtures extends Fixture
{
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create("fr_FR");
        $this->loadAuteur($manager, $faker);
        $this->loadUsers($manager, $faker);
        $this->loadLivre($manager, $faker);
        $this->loadGenre($manager, $faker);
        $this->loadEmprunteur($manager, $faker);
        $this->loadEmprunt($manager, $faker);
        $manager->flush();
    }

    // Create users
    public function loadUsers(ObjectManager $manager, FakerGenerator $faker): void
    {
        $userDatas = [
            [
                "email" => "admin@exemple.com",
                "roles" => "[ROLE_ADMIN]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 09:00:00')
            ],

            [
                "email" => "foo.foo@exemple.com",
                "roles" => "[ROLE_EMPRUNTEUR]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00')
            ],

            [
                "email" => "bar.bar@exemple.com",
                "roles" => "[ROLE_EMPRUNTEUR]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => false,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 11:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-05-01 12:00:00')
            ],

            [
                "email" => "baz.baz@exemple.com",
                "roles" => "[ROLE_EMPRUNTEUR]",
                "password" => "$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K",
                "enabled" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-03-01 12:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-03-01 12:00:00')
            ]
        ];
        
        foreach ($userDatas as $userData){
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles($userData["roles"]);
            $user->setPassword($userData['password']);
            $user->setEnabled($userData['enabled']);
            $user->setCreatedAt($userData['created_at']);
            $user->setUpdatedAt($userData['updated_at']);

            $manager->persist($user);
        }

        for($i=0;$i<100;$i++){
            $user = new User();
            $user->setEmail($faker->email());
            $user->setRoles("[ROLE_EMPRUNTEUR]");
            $user->setPassword("$2y$10$/H2ChUxriH.0Q33g3EUEx.S2s4j/rGJH2G88jK9nCP60GbUW8mi5K");
            $user->setEnabled($faker->boolean());
            // date for created_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $user->setCreatedAt($date);
            // date for updated_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $user->setUpdatedAt($date);

            $manager->persist($user);
        }
    }

    // Create Livre

    public function loadLivre(ObjectManager $manager, FakerGenerator $faker): void
    {
        $livreDatas = [
            [
                "titre" => "Lorem ipsum dolor sit amet",
                "annee_edition" => "2010",
                "nombre_pages" => "100",
                "code_isbn" => "9785786930024"
            ],
            [
                "titre" => "Consectetur adipiscing elit",
                "annee_edition" => "2011",
                "nombre_pages" => "150",
                "code_isbn" => "9783817260935"
            ],
            [
                "titre" => "Mihi quidem Antiochum",
                "annee_edition" => "2012",
                "nombre_pages" => "200",
                "code_isbn" => "9782020493727"
            ],
            [
                "titre" => "Quem audis satis belle",
                "annee_edition" => "2013",
                "nombre_pages" => "250",
                "code_isbn" => "9794059561353"
            ]
        ];

        foreach($livreDatas as $livreData){
            $livre = new Livre();
            
            $livre->setTitre($livreData["titre"]);
            $livre->setAnneeEdition($livreData["annee_edition"]);
            $livre->setNombrePages($livreData["nombre_pages"]);
            $livre->setCodeIsbn($livreData["code_isbn"]);

            $manager->persist($livre);
        }

        for($i=0;$i<1000;$i++){
            $livre = new Livre();

            $livre->setTitre($faker->words(5, true));
            $livre->setAnneeEdition(random_int(1200, 2022));
            $livre->setNombrePages(random_int(10, 1675));
            $livre->setCodeIsbn($faker->isbn13());

            $manager->persist($livre);
        }
    }

    // Create Genre

    public function loadGenre(ObjectManager $manager, FakerGenerator $faker): void
    {
        // Possibilité de ne pas préciser "description NULL" mais je le fait car au moins c'est déjà là et + simple à remplacer par des données par la suite
        $genreDatas = [
            [
                "nom" => "poésie",
                "description" => NULL,
            ],
            [
                "nom" => "nouvelle",
                "description" => NULL,
            ],
            [
                "nom" => "roman historique",
                "description" => NULL,
            ],
            [
                "nom" => "roman d'amour",
                "description" => NULL,
            ],
            [
                "nom" => "roman d'aventure",
                "description" => NULL,
            ],
            [
                "nom" => "science-fiction",
                "description" => NULL,
            ],
            [
                "nom" => "fantasy",
                "description" => NULL,
            ],
            [
                "nom" => "biographie",
                "description" => NULL,
            ],
            [
                "nom" => "conte",
                "description" => NULL,
            ],
            [
                "nom" => "témoignage",
                "description" => NULL,
            ],
            [
                "nom" => "théâtre",
                "description" => NULL,
            ],
            [
                "nom" => "essai",
                "description" => NULL,
            ],
            [
                "nom" => "journal intime",
                "description" => NULL,
            ],
        ];

        foreach($genreDatas as $genreData){
            $genre = new Genre();

            $genre->setNom($genreData["nom"]);
            $genre->setDescription($genreData["description"]);

            $manager->persist($genre);
        }
    }

    // Create Emprunteur
    public function loadEmprunteur(ObjectManager $manager, FakerGenerator $faker): void
    {
        $repository = $this->doctrine->getRepository(User::class);
        $users = $repository->findAll();

        $emprunteurDatas = [
            [
                "nom" => "foo",
                "prenom" => "foo",
                "tel" => "123456789",
                "actif" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-01-01 10:00:00'),
            ],
            [
                "nom" => "bar",
                "prenom" => "bar",
                "tel" => "123456789",
                "actif" => false,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-02-01 11:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-05-01 12:00:00'),
            ],
            [
                "nom" => "foo",
                "prenom" => "foo",
                "tel" => "123456789",
                "actif" => true,
                "created_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-03-01 12:00:00'),
                "updated_at" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', '2020-03-01 12:00:00'),
            ]
        ];

        foreach($emprunteurDatas as $emprunteurData){
            $emprunteur = new Emprunteur();
            $emprunteur->setNom($emprunteurData["nom"]);
            $emprunteur->setPrenom($emprunteurData["prenom"]);
            $emprunteur->setTel($emprunteurData["tel"]);
            $emprunteur->setActif($emprunteurData["actif"]);
            $emprunteur->setCreatedAt($emprunteurData["created_at"]);
            $emprunteur->setUpdatedAt($emprunteurData["updated_at"]);

            $manager->persist($emprunteur);
        }

        for($i=0;$i<100;$i++){
            $emprunteur = new Emprunteur();

            $emprunteur->setNom($faker->lastName());
            $emprunteur->setPrenom($faker->firstName());
            $emprunteur->setTel($faker->phoneNumber());
            $emprunteur->setActif($faker->boolean());
            // date for created_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $emprunteur->setCreatedAt($date);
            // date for updated_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $emprunteur->setUpdatedAt($date);

            $manager->persist($emprunteur);
        }
    }

    // Create Emprunt
    function loadEmprunt(ObjectManager $manager, FakerGenerator $faker): void
    {
        $empruntDatas = [
            [
                "date_emprunt" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2020-02-01 10:00:00"),
                "date_retour" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2020-03-01 10:00:00"),
            ],
            [
                "date_emprunt" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2020-03-01 10:00:00"),
                "date_retour" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2020-04-01 10:00:00"),
            ],
            [
                "date_emprunt" => DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2020-02-01 10:00:00"),
                "date_retour" => NULL,
            ],
        ];

        foreach($empruntDatas as $empruntData){
            $emprunt = new Emprunt;

            $emprunt->setDateEmprunt($empruntData["date_emprunt"]);
            $emprunt->setDateRetour($empruntData["date_retour"]);

            $manager->persist($emprunt);
        }

        for($i=0;$i<200;$i++){
            $emprunt = new Emprunt;

            // date for created_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $emprunt->setDateEmprunt($date);
            // date for updated_at
            $date = $faker->dateTimeBetween('-6 month', '+6 month');
            $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2022-{$date->format('m-d H:i:s')}");
            $emprunt->setDateRetour($date);

            $manager->persist($emprunt);
        }
    }

    public function loadAuteur(ObjectManager $manager, FakerGenerator $faker){
        $auteurDatas = [
            [
                "nom" => "auteur inconnu",
                "prenom" => "",
            ],
            [
                "nom" => "Cartier",
                "prenom" => "Hugues",
            ],
            [
                "nom" => "Lambert",
                "prenom" => "Armand",
            ],
            [
                "nom" => "Moitessier",
                "prenom" => "Thomas",
            ]
        ];

        foreach($auteurDatas as $auteurData){
            $auteur = new Auteur();

            $auteur->setNom($auteurData["nom"]);
            $auteur->setPrenom($auteurData["prenom"]);

            $manager->persist($auteur);
        }

        for($i=0;$i<500;$i++){
            $auteur = new Auteur();

            $auteur->setNom($faker->lastName);
            $auteur->setPrenom($faker->firstName);

            $manager->persist(($auteur));
        }
    }
}