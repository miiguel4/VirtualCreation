<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends AbstractController
{
    /**
     * @Route("/contacto", name="app_contacto")
     */
    /* public function index(): Response
    {
        $this->sendEmail();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('contacto/index.html.twig', [
            'controller_name' => 'ContactoController',
        ]);
    } */

    public function sendEmail(MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('mruirub878@g.educaand.es')
            ->to('adminvc@correo.mrpro.comm')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);

        // ...
    }
    
}
