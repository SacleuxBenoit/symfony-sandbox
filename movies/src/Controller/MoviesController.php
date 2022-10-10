<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route('/movies', name: 'app_movies')]
    public function index()
    {
        return $this->render('index.html.twig', [
            'title' => "Avengers: Endgame"
        ]);
    }
    
    /**
     * oldMethod
     *
     * @Route("/old", name="old")
     */
    public function oldMethod(): JsonResponse {
        return $this->json([
            'message' => 'Welcome to your old controller!',
            'path' => 'src/Controller/MoviesController.php',
        ]);
    }
}