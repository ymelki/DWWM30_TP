<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Commande;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Service\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommandeController extends AbstractController
{

    #[Route('/profile/commande/success', name: 'app_commande_sucess')]
    public function sucess(){
        dd('le paiement est OK ! ');
    } 


    #[Route('/profile/commande/cancel', name: 'app_commande_cancel')]
    public function cancel(){
        dd('le paiement est KO ! ');
    } 

    #[Route('/profile/commande', name: 'app_commande')]
    public function index(
        CommandeRepository $commandeRepository,
        RequestStack $session,
        ProduitRepository $produitRepository,
        CartService $cart


    ): Response
    {
        // stocké le user
        // this->getUser()
        // stocké le produit
        // via le param converter
        // et la quantité via la session
 
         // stocké le user
        // this->getUser()

        // recuperation du panier
    /*    $panier=$session->getSession()->get("panier");

        // boucler sur chaque ligne du panier
        foreach ($panier as $key => $value  ){ 
            
            $commande = new Commande();
            $commande->setUsers($this->getUser());
            $commande->setProduits($produitRepository->find($key));
            $commande->setQuantite($value);
            $commandeRepository->save($commande, true);

        }*/


        //1. Payer sur STRIPE
        // communiquer avec stripe

        // on a le montant du panier
        $montant=$cart->getTotalAll()*100;

        // clé secrete pour que stripe me reconnaisse
        $stripeSecretKey="sk_test_51KqHUhHxTuewjfx8W4mdPLu0MLeDPM0uBpINTS0lv1lxUEkSOfK7UXbvOK8WtTFUNau0cB4hKVk4FPTMfmSSZZZh00vo9JBk6o";
        Stripe::setApiKey($stripeSecretKey);
  
        $protocol="http://";
        $serveur=$_SERVER['SERVER_NAME'];
        $YOUR_DOMAIN=$protocol.$serveur;

        // on lance la communication avec stripe



        $checkout_session = \Stripe\Checkout\Session::create([
            'line_items' => [[
              # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
              'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $montant,
                'product_data' => [
                  'name' => 'Paiement de votre panier'
                ],
              ],
              'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/profile/commande/success',
            'cancel_url' => $YOUR_DOMAIN . '/profile/commande/cancel',

        ]);
 
          
        //2. Savegarde en B.D.

        //3. Supprimer la session
  
        
        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'id_session'=>$checkout_session->id
        ]);
    }
}
