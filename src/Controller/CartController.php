<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/*

Clé = Valeur
[clé] = valeur

[
    [clé]=>[valeur]
]
/cart/add/7
/cart/add/8
/cart/add/8


    [7]=>1
    [8]=>2




*/

#[Route('/cart')]
class CartController extends AbstractController
{
    // page d'ajout de produit
    #[Route('/add/{id}', name: 'app_cart_add')]
    public function index
    ($id,
    RequestStack $session
    ):  Response
    {      
        // créé mon panier à vide si il n'existe pas 
        // le 2 parametre []
        // si il existe deja je recupere l'existant

        $panier=$session->getSession()->get("panier",[]);

        // dans le cas ou la clé n'a jamais été alimenté
        // on a beoin de la créé avec une valeur
        if (empty($panier[$id])){
            // si le $panier[7] n'existe pas à la met à 0.
            $panier[$id]=0;
        }
        // dans le tableau de mon panier j'ai
        ///cart/add/7
        // $panier[7] je lui rajoute 1 dans sa veleur
        $panier[$id]++;

        // ici on modifie à chaque passage la variable panier
        // au niveau de la session
        // [7]=>1
        $session->getSession()->set("panier",$panier);

        // redirection vers la page des produits
         return $this->redirectToRoute("app_produit_index",[], Response::HTTP_SEE_OTHER);

    }

    // page pour visualiser notre panier
    #[Route('/show', name: 'app_cart_show')]
    public function show(RequestStack $session): Response
    {
        //get pour recuperer la session
        // dd($session->getSession()->get("panier"));
        $panier=$session->getSession()->get("panier");

        return $this->render('cart/index.html.twig', [
            'panier' => $panier,
        ]);
    }

    // page pour vider notre panier
    #[Route('/clear', name: 'app_cart_clear')]
    public function clear(RequestStack $session): Response
    {
        // remove pour vider la session
        $session->getSession()->remove("panier");


        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }
}
