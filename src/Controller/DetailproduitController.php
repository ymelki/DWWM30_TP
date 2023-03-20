<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\CommentaireRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailproduitController extends AbstractController
{
    #[Route('/detailproduit/{id}', name: 'app_detailproduit')]
    public function index(Produit $produit , CommentaireRepository $commentaireRepository): Response
    {
        // on veut afficher les commentaires 
        // correspondant aux produit de l'id de l'url.
        // on utilise le repository qui va chercher avec un critere findby
        // selon le produits 
        dd($commentaireRepository->findAll());
        dd($commentaireRepository->findBy([

            'produits'=>$produit
          ]   
        ));   
        dd($produit);
        // $produit correspond à l'entité produit de l'identifiant envoyé
        // en parametre
     
        return $this->render('detailproduit/index.html.twig', [
            'controller_name' => 'DetailproduitController',
        ]);
    }
}
