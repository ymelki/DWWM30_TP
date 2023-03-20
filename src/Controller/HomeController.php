<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $tab_identite=[
            "nom"=>"Melki",
            "prenom"=>"Yoel",
            "age"=>35
        ];
        
        
        //$this->addFlash("message","Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue ! ");

        // var_dump($tab_identite);
        return $this->render('home/index.html.twig', [
            'identite' => $tab_identite, 
        ]);
    }
}
