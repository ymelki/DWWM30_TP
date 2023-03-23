<?php

namespace App\Controller;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MailerInterface $mailer): Response
    {
        // tester l'envoie de mail
        $email = (new Email())
        ->from('hello@example.com')
        ->to('you@example.com')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Time for Symfony Mailer!')
        ->text('Sending emails is fun again!')
        ->html('<p>See Twig integration for better HTML integration!</p>');

         $mailer->send($email);


        // $this->addFlash('success', 'La catégorie a bien été créée'); // message de succès (message flash)

        $tab_identite=[
            "nom"=>"Melki",
            "prenom"=>"Yoel",
            "age"=>35
        ];
        
        
        //$this->addFlash("message","Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue !Bienvenue ! ");

        // var_dump($tab_identite);
        return $this->render('home/index.html.twig', [
            'identite' => $tab_identite, 
        ]);
    }
}
