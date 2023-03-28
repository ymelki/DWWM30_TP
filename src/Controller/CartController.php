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
    ): Response
    {
         

        // créé mon panier à vide si il n'existe pas 
        // le 2 parametre []
        // si il existe deja je recupere l'existant

        $panier=$session->getSession()->get("panier",[]);
        // dans le tableau de mon panier j'ai
        ///cart/add/7
        // $panier[7] je lui rajoute 1 dans sa veleur
        $panier[7]++   ;

        // ici on modifie à chaque passage la variable panier
        // au niveau de la session
        // [7]=>1
        $session->getSession()->set("panier",$panier);

        dd($panier);

         return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }

    // page pour visualiser notre panier
    #[Route('/show', name: 'app_cart_show')]
    public function show(RequestStack $session): Response
    {
        //get pour recuperer la session
        dd($session->getSession()->get("panier"));


        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
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
