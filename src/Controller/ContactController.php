<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
 use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(MailerInterface $mailer, Request $request): Response
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
        $email = (new Email())
        ->from($email_form)
        ->to($email_form)
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Time for Symfony Mailer!')
        ->text($data['Votre_message'])
        ->html($data['Votre_message']);

        $mailer->send($email);




        return $this->renderForm('contact/traitement.html.twig', [
        ]);


   
    } 
    // CAS ou le formulaire s'affiche
    return $this->renderForm('contact/index.html.twig', [
        'form' => $form,
    ]);

    }
}