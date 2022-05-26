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
        $this->crear();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('creacionmaquina/index.html.twig', [
            'controller_name' => 'CreacionmaquinaController',
        ]);
       
    }

    public function insertar() {
        
        if (isset($_POST['crear'])) {
            /*Comprobar si hay ya creada una maquina con esa nombre en la base de datos*/
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

            return new Response('Se ha creado el producto con id: '.$parametro->getId());
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
            
            /* "SELECT * FROM parametros WHERE nombre LIKE '%iguel2'"; */

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
                print_r("$adaptadorred");
                putenv("GOVC_INSECURE=true");
                putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                putenv("GOVC_DATASTORE=datastore1");
                putenv("GOVC_NETWORK=VM Network");
                /* shell_exec("govc vm.create -on=false  -m 2048 -c 2 -g windows9_64Guest -disk=20Gb -disk.controller=pvscsi -iso=ISO/windowsServer2019.iso WindowsServer2019"); */
                shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/windowsServer2019.iso '.$nombremaquina.'');
            }
            
            
          /*  echo shell_exec("vmrc --user=root --password=Tt.676559546 --moid=5 --host=192.168.1.38"); */
            
        } 
    }
    
}
