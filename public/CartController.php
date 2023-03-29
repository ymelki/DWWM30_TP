<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Service\CartService;
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
    public function show(
        ProduitRepository $produitRepository,
        RequestStack $session): Response
    {
        //get pour recuperer la session
        // dd($session->getSession()->get("panier"));
        $panier=$session->getSession()->get("panier");

        // créé un panier contenant les infos sur le produits

        $panier_complet=[];

        // je boucle sur la cle et la valeur
        // du panier
        // clé de 7 sa valeur est la quantité
        $total=0;
        foreach ($panier as $key => $value  ){
            $produit_encours= $produitRepository->find($key);

            $panier_complet[]=[
                'produit'=> $produit_encours ,
                'quantite'=>$value,
                'total'=>($produit_encours->getPrix()*$value),
                ];
                // accumule la variable total avec chacun des prix
            $total=$total+($produit_encours->getPrix()*$value);
             
        }
        //dd($panier_complet);




        return $this->render('cart/index.html.twig', [
            'panier' => $panier_complet,
            'total' =>$total
        ]);
    }



    
    // page pour vider notre panier
    #[Route('/remove/{id}', name: 'app_cart_test')]
    public function remove($id,
    CartService $cartService
    // RequestStack $requestStack
     ): Response
    { 
        // ancien controller sans service
        // $panier=$requestStack->getSession()->get("panier");
        // $panier[$id]--;

        // redirection vers la page des produits
        $cartService->remove($id);
        return $this->redirectToRoute("app_cart_show",[], Response::HTTP_SEE_OTHER);

    }
 
    // page pour vider notre panier
    #[Route('/clear', name: 'app_cart_clear')]
    public function clear(RequestStack $session): Response
    {
        // remove pour vider la session
        $session->getSession()->remove("panier");


        // redirection vers la page des produits
        return $this->redirectToRoute("app_produit_index",[], Response::HTTP_SEE_OTHER);

    }
 
}
