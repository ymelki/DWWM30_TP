<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\FactureRepository;
use App\Repository\UserRepository;
 use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(
        FactureRepository $factureRepository
    ): Response
    {        
        // recuperation du user en cours
        $monuser=$this->getUser();

        // recuperation des factures selon le user en cours
        $facture_user=$factureRepository->findBy([
            'users'=>$monuser
        ]);
 

        return $this->render('user/index.html.twig', [
            'user' => $monuser,
            'factures'=> $facture_user
        ]);
    }

    

    #[Route('/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $user=$this->getUser();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

}
