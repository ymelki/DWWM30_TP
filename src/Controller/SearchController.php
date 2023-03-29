<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(
        ProduitRepository $produitRepository,
        Request $request): Response
    {
        // recuperer les donnée envoyé dans le POST
        $search=$request->query->get('search');
        // dd($produitRepository->findAll());

        $result=$produitRepository->findBy(
           ['titre'=> $search
           ]

        );
        dd($result);
       

        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }
}
