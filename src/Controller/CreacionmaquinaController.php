<?php

namespace App\Controller;

use App\Entity\Parametros;
use App\Form\ParametrosType;
use App\Repository\ParametrosRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CreacionmaquinaController extends AbstractController {
    /**
     * @Route("/creacionmaquina", name="app_creacionmaquina")
     */
    public function index(): Response {
        $this->insertar();
        /* $this->crear(); */
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('creacionmaquina/index.html.twig', [
            'controller_name' => 'CreacionmaquinaController',
        ]);
       
    }

    public function insertar() {
        
        if (isset($_POST['crear'])) {
      
            $email = $this->getUser()->getEmail();
            $posicion = strpos($email, '@');
            $nombreUser = substr($email, 0, $posicion);
            $datastore = $_POST['datastore'];
            $CPU = $_POST['CPU'];
            $memoria = $_POST['memoria'];
            $sistemaOperativo = $_POST['sistemaOperativo'];
            $nombremaquina = $_POST['nombremaquina'];
            $nombremaquinaUser = $_POST['nombremaquina'].$nombreUser;
            $adaptadorred = $_POST['adaptadorred'];
            
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT p
                FROM App:Parametros p
                WHERE p.Nombre LIKE :nombre'
            )->setParameter('nombre', $nombremaquinaUser);

            $buscar = $query->getResult();
           
            if (empty($buscar)) {
                $parametro = new Parametros();
                $parametro->setDatastore($datastore);
                $parametro->setCPU($CPU);
                $parametro->setMemoria($memoria);
                $parametro->setSistemaOperativo($sistemaOperativo);
                $parametro->setNombre( $nombremaquinaUser);
                $parametro->setAdaptadorRed($adaptadorred);

                $em = $this->getDoctrine()->getManager();

                $em->persist($parametro);
                $em->flush();

                echo '<script language="javascript">alert("Maquina Creada");</script>';
                
            } else {
                echo '<script language="javascript">alert("Ya existe ese nombre!!!, por favor intenta con otro.");</script>';
            } 
        } 
     
    }

    public function crear() {
        if (isset($_POST['crear'])) {
            $email = $this->getUser()->getEmail();
            $posicion = strpos($email, '@');
            $nombreUser = substr($email, 0, $posicion);
            $nombremaquina = $_POST['nombremaquina'];
            $nombremaquinaUser = $_POST['nombremaquina'].$nombreUser;
            $caracteres = substr($nombremaquinaUser, -6);
            
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery(
                'SELECT p
                FROM App:Parametros p
                WHERE p.Nombre LIKE :nombre'
            )->setParameter('nombre', $nombremaquinaUser);

            $parametros = $query->getResult();
            foreach ($parametros as  $parametro) {
                $datastore = $parametro->getDatastore();
                $CPU = $parametro->getCPU();
                $memoria = $parametro->getMemoria();
                $sistemaOperativo = $parametro->getSistemaOperativo();
                $nombremaquina = $parametro->getNombre();
                $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                putenv("GOVC_INSECURE=true");
                putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                putenv("GOVC_DATASTORE=datastore1");
                putenv("GOVC_NETWORK=VM Network");
                // Comprobar el sistema operativo
                shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/windowsServer2019.iso '.$nombremaquina.'');
            }    
        } 
    }
    
}
