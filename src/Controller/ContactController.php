<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Service\EmailService;
use Symfony\Component\Mime\Email;
 use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(
        EmailService $emailService,
        Request $request): Response
    {
 
    $form=$this->createForm(ContactType::class);
        

     // cas ou le formulaire a été validé
   // on prend l'objet form qui va lire la request
   $form->handleRequest($request);

   // test si l'envoie en post et est valide est bien envoyé
   if ($form->isSubmitted() && $form->isValid()) {

       // creer une variable data qui est un tableau clé valeur
       // contenant les données envoyé en POST
       $data=$form->getData();
       $email_form=$data['Votre_email'];
       $message_form=$data['Votre_message'];

       // on va envoyé le mail
       // tester l'envoie de mail
       $emailService->envoyer(
        $email_form,
        $data['Votre_message']);
         




        return $this->renderForm('contact/traitement.html.twig', [
        ]);


   
    } 
    // CAS ou le formulaire s'affiche
    return $this->renderForm('contact/index.html.twig', [
        'form' => $form,
    ]);

    }
}