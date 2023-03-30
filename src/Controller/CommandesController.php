<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Facture;
use App\Form\CommandesType;
use App\Repository\CommandesRepository;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile/commandes')]
class CommandesController extends AbstractController
{
    #[Route('/{id}', name: 'app_commandes_index', methods: ['GET'])]
    public function index(
        Facture $facture,
        CommandesRepository $commandesRepository,
        ProduitRepository $produitRepository
        ): Response
    {
        // recuperation des commandes pour la facture
        // envoyé en ID
        $mescommandes=$commandesRepository->findBy(
            ['factures'=>$facture]
        );

        // les commandes n'ont pas les infos du produits.

        // on boucle dessus pour les recuperer

        $total=0;
        $produit_complet=[];
        foreach ($mescommandes as $value){
            $produit_complet[]=[
                'produit_prix'=>$value->getProduit()->getPrix(), 
                'nom_produit'=>$value->getProduit()->getTitre(),
                 'id'=> $value->getProduit()->getId(),
                'quantite'=> $value->getQuantite(),
                'total'=>$value->getQuantite() * $value->getProduit()->getPrix()
            ] ;
            $total=$total+($value->getQuantite() * $value->getProduit()->getPrix());
        }
        


        return $this->render('commandes/index.html.twig', [
            'commandes' =>$produit_complet,
            'total_commande' =>$total
        ]);
    }
 

    #[Route('/{id}', name: 'app_commandes_show', methods: ['GET'])]
    public function show(Commandes $commande): Response
    {
        return $this->render('commandes/show.html.twig', [
            'commande' => $commande,
        ]);
    }
 
}
