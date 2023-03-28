<?php

namespace App\Controller;

use App\Form\JeuType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JeuController extends AbstractController
{
    #[Route('/jeu', name: 'app_jeu')]
    public function index(RequestStack $requestStack, Request $request): Response
    { 
   //     $requestStack->getSession()->get('identite');
   //     $requestStack->getSession()->remove("unpanierdetest");
   //     dd($requestStack->getSession()->get('unpanierdetest'));

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
            // $data['alea']=rand(1,100);

            // un nombre aleatoire va être généré et va être stocké dans
            // une variable nb alea

            // si la variable nb_alea de la session existe deja
            // alors tu fais rien
            // si elle existe pas alors tu la créé
            // $requestStack->getSession()->remove("nb_alea");
            if 
            (
                (!$requestStack->getSession()->get("nb_alea")) ||
                ($requestStack->getSession()->get("nb_chance")) < 1
            ){
                // 1 er fois on créé une variable aleatoire
                // 1 er fois un cree une variable contenant 5 chances
                $data['alea']= $requestStack->getSession()->set("nb_alea", rand(1,100));
                $data['nb_chance']= $requestStack->getSession()->set("nb_chance", 6);

            }
            
            // on MAJ le nbre de chance. on perd une chance à chaque coup
            $requestStack->getSession()->set("nb_chance", 
            $requestStack->getSession()->get("nb_chance")-1
            );

            // on stock l'info pour le rendu dans $data
            $data['alea'] = $requestStack->getSession()->get("nb_alea");

       
            
            $data['nb_chance']=$requestStack->getSession()->get("nb_chance");

            // dd($requestStack->getSession()->get("nb_chance"));
        
    
            // on créé une clé reponse dans la variable data 
            // contenant gagné ou perdu !
            if ($data['alea'] == $data['nombre']){
                $data['reponse']="Gagné";
            }
            else   {
    
                $data['reponse']="Perdu";
            } 
    
            // on va tester elle est égal à ce qui est inséré
    
    
        
           
            return 
            
            $this->render('jeu/traitement.html.twig', [
                'mes_donnes'=>$data ,
                
            ]);
        }
        return $this->renderForm('jeu/index.html.twig', [
            'form' => $form,
        ]);
    }
}
