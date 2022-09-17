<?php
namespace App\Controller;

use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DbTestController extends AbstractController{
    #[Route('/db/test',name:"app_db_test")]
    public function index(ManagerRegistry $doctrine) :Response
    {
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->findAll();
        dump($user);
        exit();
    }
}


?>