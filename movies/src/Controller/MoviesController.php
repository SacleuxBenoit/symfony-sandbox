<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    #[Route('/movies/{name}', name: 'app_movies', defaults:['name' => null], methods:['GET', 'HEAD'])]
    public function index($name): JsonResponse
    {
        return $this->json([
            'message' => "this is " . $name,
            'path' => 'src/Controller/MoviesController.php',
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
