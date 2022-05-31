<?php

namespace App\Controller;

use App\Entity\Parametros;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
            $tipo = $_POST['tiposistema'];
           
            if (empty($tipo)) {
                echo '<script language="javascript">alert("El tipo no debe de estar vacio.");</script>';
            } else {
                $em = $this->getDoctrine()->getManager();
                $query = $em->createQuery(
                    'SELECT p
                    FROM App:Parametros p
                    WHERE p.Nombre LIKE :nombre'
                )->setParameter('nombre', $nombremaquinaUser);

                $parametros = $query->getResult();

                if ($tipo  == "WindowsServer2019") {
                    foreach ($parametros as  $parametro) {
                        $CPU = $parametro->getCPU();
                        $memoria = $parametro->getMemoria();
                        $nombremaquina = $parametro->getNombre();
                        $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                        putenv("GOVC_INSECURE=true");
                        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                        putenv("GOVC_DATASTORE=datastore1");
                        putenv("GOVC_NETWORK=VM Network");

                        shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/windowsServer2019.iso '.$nombremaquina.'');
                    } 
                } elseif ($tipo  == "WindowsServer2016") {
                    foreach ($parametros as  $parametro) {
                        $CPU = $parametro->getCPU();
                        $memoria = $parametro->getMemoria();
                        $nombremaquina = $parametro->getNombre();
                        $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                        putenv("GOVC_INSECURE=true");
                        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                        putenv("GOVC_DATASTORE=datastore1");
                        putenv("GOVC_NETWORK=VM Network");
                        
                        shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/WindowsServer2016.iso '.$nombremaquina.'');
                    } 
                } elseif ($tipo == "Windows10") {
                    foreach ($parametros as  $parametro) {
                        $CPU = $parametro->getCPU();
                        $memoria = $parametro->getMemoria();
                        $nombremaquina = $parametro->getNombre();
                        $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                        putenv("GOVC_INSECURE=true");
                        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                        putenv("GOVC_DATASTORE=datastore1");
                        putenv("GOVC_NETWORK=VM Network");
                        
                        shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/windows10.iso '.$nombremaquina.'');
                    } 
                } elseif ($tipo == "debian10") {
                    foreach ($parametros as  $parametro) {
                        $CPU = $parametro->getCPU();
                        $memoria = $parametro->getMemoria();
                        $nombremaquina = $parametro->getNombre();
                        $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                        putenv("GOVC_INSECURE=true");
                        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                        putenv("GOVC_DATASTORE=datastore1");
                        putenv("GOVC_NETWORK=VM Network");
                        
                        shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/debian-10.6.0-amd64-netinst.iso '.$nombremaquina.'');
                    } 
                } elseif ($tipo  == "debian11") {
                    foreach ($parametros as  $parametro) {
                        $CPU = $parametro->getCPU();
                        $memoria = $parametro->getMemoria();
                        $nombremaquina = $parametro->getNombre();
                        $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                        putenv("GOVC_INSECURE=true");
                        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                        putenv("GOVC_DATASTORE=datastore1");
                        putenv("GOVC_NETWORK=VM Network");
                        
                        shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/debian-11.3.0-amd64-netinst.iso '.$nombremaquina.'');
                    } 
                } elseif ($tipo == "ubuntu20server") {
                    foreach ($parametros as  $parametro) {
                        $CPU = $parametro->getCPU();
                        $memoria = $parametro->getMemoria();
                        $nombremaquina = $parametro->getNombre();
                        $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                        putenv("GOVC_INSECURE=true");
                        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                        putenv("GOVC_DATASTORE=datastore1");
                        putenv("GOVC_NETWORK=VM Network");
                        
                        shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/ubuntu-20.04.1-server.iso '.$nombremaquina.'');
                    } 
                } else {
                    foreach ($parametros as  $parametro) {
                        $CPU = $parametro->getCPU();
                        $memoria = $parametro->getMemoria();
                        $nombremaquina = $parametro->getNombre();
                        $adaptadorred = $parametro->getAdaptadorRed()."Gb";
                        putenv("GOVC_INSECURE=true");
                        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
                        putenv("GOVC_DATASTORE=datastore1");
                        putenv("GOVC_NETWORK=VM Network");
                        
                        shell_exec('govc vm.create -on=false  -m '.$memoria.' -c '.$CPU.' -g windows9_64Guest -disk='.$adaptadorred.' -disk.controller=pvscsi -iso=ISO/ubuntu-20.04.1-desktop.iso '.$nombremaquina.'');
                    } 
                }
            }
        } 
    }
}
