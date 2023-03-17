<?php

namespace App\Controller;

use App\Form\JeuType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'app_jeu')]
    public function index(Request $request): Response
    {
        $form=$this->createForm(JeuType::class);

        // on prend l'objet form qui va lire la request
        $form->handleRequest($request);

        // test si l'envoie en post et est valide est bien envoyé
        if ($form->isSubmitted() && $form->isValid()) {
 
            // creer une variable data qui est un tableau clé valeur
            // contenant les données envoyé en POST
            $data= $form->getData();
    
           
    
            // une variable aléatoire va être généré  et 
            // stocké dans le tableau data sur la clé alea
            $data['alea']=rand(1,100);
        
    
            // on créé une clé reponse dans la variable data 
            // contenant gagné ou perdu !
            if ($data['alea'] == $data['nombre']){
                $data['reponse']="Gagné";
            }
            else   {
    
                $data['reponse']="Perdu";
            } 
    
            // on va tester elle est égal à ce qui est inséré
    
    
        
         
            return $this->render('jeu/traitement.html.twig', [
                'mes_donnes'=>$data ,
            ]);
        }
        return $this->renderForm('jeu/index.html.twig', [
            'form' => $form,
        ]);
    }
}
