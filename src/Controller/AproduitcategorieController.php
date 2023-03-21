<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\AproduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AproduitcategorieController extends AbstractController
{
    #[Route('/aproduitcategorie/{id}', name: 'app_aproduitcategorie')]
    public function index(Categorie $categorie, AproduitRepository $aproduitRepository): Response
    {
        $produit_cat=$aproduitRepository->findBy([
            'categories'=>$categorie
        ]);
        // dd($categorie);
        // dd($aproduitRepository->findAll());
        return $this->render('aproduitcategorie/index.html.twig', [
            'produit_cat' => $produit_cat,
        ]);
    }
}
