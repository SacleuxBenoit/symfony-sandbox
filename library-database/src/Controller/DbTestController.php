<?php
namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DbTestController extends AbstractController{
    #[Route('/db/test',name:"app_db_test")]
    public function index(ManagerRegistry $doctrine) :Response
    {
        exit();
    }
}


?>