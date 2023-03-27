<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(
        RequestStack $session,
        CategorieRepository $categorieRepository): Response
    {
        
        // si je voulais la supprimer
        // $session->getSession()->remove("identite");
        // on test la récuperation pour l'afficher
        // avec un get
        dd($session->getSession()->get("identite"));

        
        return $this->render('categorie/index.html.twig', [
            'categories' => $categorieRepository->findAll(),
        ]);
    }
}
