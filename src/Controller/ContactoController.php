<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ContactoController extends AbstractController
{
    /**
     * @Route("/contacto", name="app_contacto")
     */
    public function index(): Response {
        $this->sendEmail();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('contacto/index.html.twig', [
            'controller_name' => 'ContactoController',
        ]);
    } 

    public function sendEmail() {
        if (isset($_POST['enviar'])) {

            $correo = $_POST['email'];
            $nombre = $_POST['nombre'];
            $mensaje = $_POST['mensaje'];

            $email = (new Email())
            ->from($correo)
            ->to('adminvc@correo.mrpro.com')
            ->subject('Mensaje Sorporte')
            ->text('Sending emails is fun again!')
            ->html("Nombre del usuario: ".$nombre."<br> Mensaje: ".$mensaje);
            $dns = 'smtp://correo.mrpro.com:25?verify_peer=false';
            $transport = Transport::fromDsn($dns);
            $transport->send($email);
        }
    }
}


