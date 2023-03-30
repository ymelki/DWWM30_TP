<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RequestStack $requestStack  ): Response
    {
        //$this->addFlash("success", "Pas mal !");

        // on créé un tableau identité avec 3 cases 
        // nom et prenom et age.
         $tab_identite=[
            "nom"=>"Melki",
            "prenom"=>"Yoel",
            "age"=>35
        ];

        // on créé une variable qu'on appelle identite qui va contenir
        // le tableau créé au dessus
        // qu'on stock en session
        // créé c'est un SET
        $requestStack->getSession()->set("identite",$tab_identite);

        $requestStack->getSession()->set("identite",[
            "nom"=>"Melki",
            "prenom"=>"Yoel",
            "age"=>35
        ]);

    //    $requestStack->getSession()->set( "unpanierdetest","rien"   );

      //  dd($requestStack->getSession());


        
        
        
        //$this->addFlash("message","Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue ! ");

        // var_dump($tab_identite);
        return $this->render('home/index.html.twig', [
            'identite' => $tab_identite, 
        ])
        // $this->addFlash('success', 'La catégorie a bien été créée'); // message de succès (message flash)

        ;
    }
}
