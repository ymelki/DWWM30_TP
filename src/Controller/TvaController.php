<?php

namespace App\Controller;

use App\Form\TvaType;
use App\Service\TvaService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TvaController extends AbstractController
{
    #[Route('/tva', name: 'app_tva')]
    public function index(Request $request, TvaService $tvaService): Response
    {
        $form = $this->createForm(TvaType::class);


        
        // on prend l'objet form qui va lire la request
        $form->handleRequest($request);

        // test si l'envoie en post et est valide est bien envoyé
        if ($form->isSubmitted() && $form->isValid()) {
            // creer une variable task qui est un tableau clé valeur
            // contenant les données envoyé en POST
            $data= $form->getData();

            // calcul qui est fait dans le controlleur
            // on veut l'externaliser
            // nouveau code
            // une sorte de fonction qui va nous renvoyé le prix * 0.2
            // l'information correspondant prix elle soit envoyé au
            // service. On peut imaginer de creer un parametre TVA
            // permettant de gerer les different types de TVA
            //Tvaservice($data['prix']);
            
            // Ancien code

            $data['tva']=$data['prix']*0.2;

            // nouvau code
            $data['tva']=$tvaService->calcul($data['prix']);

            // renvoie une twig contenant les données du form
            // avec la variable task
            return $this->render('tva/traitement.html.twig', [
                'mes_donnes'=>$data 
            ]);

            // dd($task);
        } 


        return $this->renderForm('tva/index.html.twig', [
            'form'=>$form
        ]);
    }
}
