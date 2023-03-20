<?php

namespace App\Controller;

use App\Entity\Produit;
 use App\Repository\CommentaireRepository;
use App\Form\ProduitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DetailproduitController extends AbstractController
{
    #[Route('/detailproduit/{id}', name: 'app_detailproduit')]
    public function index(Produit $produit , CommentaireRepository $commentaireRepository): Response
    {
         $form = $this->createForm(ProduitType::class);

        // on veut afficher les commentaires 
        // correspondant aux produit de l'id de l'url.
        // on utilise le repository qui va chercher avec un critere findby
        // selon le produits 
        // $toutlescommenaire=$commentaireRepository->findAll();
        $commentaireparproduit=$commentaireRepository->findBy([

            'produits'=>$produit
          ]   
        );   

        // $produit correspond à l'entité produit de l'identifiant envoyé
        // en parametre
         return $this->renderForm('detailproduit/index.html.twig', [
            'produit' => $produit,
            'les_commentaires' => $commentaireparproduit,
            'form' => $form
         ]);
    }
}
