<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerfilController extends AbstractController
{
    /**
     * @Route("/perfil", name="app_perfil")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $email = $this->getUser()->getEmail();
        $posicion = strpos($email, '@');
        $nombreUser = substr($email, 0, $posicion);
        $nombreacortado = substr($nombreUser, -6);

        $id = $this->getUser()->getId();

            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

            $nombremaquina = shell_exec("govc find vm -name *".$id."");
            $maquinas = explode("\n", $nombremaquina);
            $numero = count($maquinas)-1;
            

        return $this->render('perfil/index.html.twig', [
            'controller_name' => 'PerfilController',
            'nombre'          => $nombreacortado,
            'numeroMaquina'   => $numero
        ]);
    }
}
