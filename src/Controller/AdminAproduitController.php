<?php

namespace App\Controller;

use App\Entity\Aproduit;
use App\Form\AproduitType;
use App\Repository\AproduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/aproduit')]
class AdminAproduitController extends AbstractController
{
    #[Route('/', name: 'app_admin_aproduit_index', methods: ['GET'])]
    public function index(AproduitRepository $aproduitRepository): Response
    {
        return $this->render('admin_aproduit/index.html.twig', [
            'aproduits' => $aproduitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_aproduit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AproduitRepository $aproduitRepository): Response
    {
        $aproduit = new Aproduit();
        $form = $this->createForm(AproduitType::class, $aproduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aproduitRepository->save($aproduit, true);

            return $this->redirectToRoute('app_admin_aproduit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_aproduit/new.html.twig', [
            'aproduit' => $aproduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_aproduit_show', methods: ['GET'])]
    public function show(Aproduit $aproduit): Response
    {
        dd($aproduit);
        return $this->render('admin_aproduit/show.html.twig', [
            'aproduit' => $aproduit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_aproduit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aproduit $aproduit, AproduitRepository $aproduitRepository): Response
    {
        $form = $this->createForm(AproduitType::class, $aproduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $aproduitRepository->save($aproduit, true);

            return $this->redirectToRoute('app_admin_aproduit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_aproduit/edit.html.twig', [
            'aproduit' => $aproduit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_aproduit_delete', methods: ['POST'])]
    public function delete(Request $request, Aproduit $aproduit, AproduitRepository $aproduitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aproduit->getId(), $request->request->get('_token'))) {
            $aproduitRepository->remove($aproduit, true);
        }

        return $this->redirectToRoute('app_admin_aproduit_index', [], Response::HTTP_SEE_OTHER);
    }
}
