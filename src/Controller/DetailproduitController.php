<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailproduitController extends AbstractController
{
    #[Route('/detailproduit/{id}', name: 'app_detailproduit')]
    public function index(Produit $produit): Response
    {
        dd($produit);
        return $this->render('detailproduit/index.html.twig', [
            'controller_name' => 'DetailproduitController',
        ]);
    }
}
