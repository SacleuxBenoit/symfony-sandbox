<?php
namespace App\Controller;

use App\Entity\User;
use App\Entity\Livre;
use App\Entity\Emprunteur;
use App\Entity\Emprunt;
use App\Entity\Genre;
use App\Entity\Auteur;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DbTestController extends AbstractController{
    #[Route('/db/test',name:"app_db_test")]
    public function index(ManagerRegistry $doctrine) :Response
    {
        // User
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findAll();
        dump($user);

        // Book
        $repository = $doctrine->getRepository(Livre::class);
        $livre = $repository->findAll();
        dump($livre);

        // Emprunteur
        $repository = $doctrine->getRepository(Emprunteur::class);
        $emprunteur = $repository->findAll();
        dump($emprunteur);

        // Emprunt
        $repository = $doctrine->getRepository(Emprunt::class);
        $emprunt = $repository->findAll();
        dump($emprunt);

        // Genre
        $repository = $doctrine->getRepository(Genre::class);
        $genre = $repository->findAll();
        dump($genre);

        // Auteur
        $repository = $doctrine->getRepository(Auteur::class);
        $auteur = $repository->findAll();
        dump($auteur);
        exit();
    }
}


?>