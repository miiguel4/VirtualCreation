<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreacionmaquinaController extends AbstractController
{
    /**
     * @Route("/creacionmaquina", name="app_creacionmaquina")
     */
    public function index(): Response
    {
        return $this->render('creacionmaquina/index.html.twig', [
            'controller_name' => 'CreacionmaquinaController',
        ]);
    }
}
