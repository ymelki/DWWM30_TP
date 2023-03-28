<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cart')]
class CartController extends AbstractController
{






    // page d'ajout de produit
    #[Route('/add/{id}', name: 'app_cart_add')]
    public function index
    (Produit $produit,
    RequestStack $session
    ): Response
    {
        // cree ou modifier la variable session set

        // créé mon panier
        $session->getSession()->set("panier",[]);

        dd($produit);
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
