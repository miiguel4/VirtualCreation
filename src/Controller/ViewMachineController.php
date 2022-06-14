<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Parametros;
use App\Entity\Log;


class ViewMachineController extends AbstractController
{
    /**
     * @Route("/view/machine", name="app_view_machine")
     */
    public function index(): Response {
        $this->conectarse();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $id = $this->getUser()->getId();
       
        putenv("GOVC_INSECURE=true");
        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
        putenv("GOVC_DATASTORE=datastore1");
        putenv("GOVC_NETWORK=VM Network");
        
        $nombremaquina = shell_exec("govc find vm -name *".$id."");
        

        if (empty($nombremaquina)) {
            $maquinas = NULL;
            $longitud = NULL;
        } else {
           /*  $estado  = shell_exec("govc vm.info *".$id." | grep 'Power state:'");
            $prueba = preg_split ("/\Name:/", $estado); */
        
            $maquinas = explode("\n", $nombremaquina);
            $longitud = strlen($id)+1;
        }

        return $this->render('view_machine/index.html.twig', [
            'controller_name' => 'ViewMachineController',
            'maquina' => $maquinas,
            'lg'      => $longitud,
        ]);

    }

    public function conectarse () {
        if (isset($_POST['conectar'])) {
            
            $id = $this->getUser()->getId();
            $nombreUsuario = $this->getUser()->getEmail();;
            $accion = $_POST['conectar'];
            $fecha =  date('m-d-Y h:i:s a', time()); 

            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

            $nombremaquina = shell_exec("govc find vm -name *".$id."");
            $maquinas = explode("\n", $nombremaquina);
            
            if (isset($_POST['checkbox'])) {
                
                foreach ($maquinas as $value) {
                    if ($value ==  $_POST['checkbox'][0]) {

                        $log = new log();
                        $log->setAccion($accion);
                        $log->setFecha($fecha);
                        $log->setUsuario($nombreUsuario);
                        $log->setNombre($_POST['checkbox'][0]);
                        $em = $this->getDoctrine()->getManager();
    
                        $em->persist($log);
                        $em->flush();
                        
                        $console =  shell_exec("govc vm.console /ha-datacenter/".$value);
                        $moid= substr(  $console, -3);
                        $number = $moid;
                    
                        if ($number == NULL) {
                            echo '<script language="javascript">alert("Por favor enciende la máquina");</script>';
                        } else {
                            $url = "vmrc://global@192.168.1.38/?moid=$number";
                            $url2 = trim($url);
                            echo '<script>window.open ("'.$url2.'")</script>';
                        }
                    }
                }
            }
        }

        if (isset($_POST['apagar'])) {

            $id = $this->getUser()->getId();
            $nombreUsuario = $this->getUser()->getEmail();;
            $accion = $_POST['apagar'];
            $fecha =  date('m-d-Y h:i:s a', time()); 

            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");
          
            if (isset($_POST['checkbox'])) {

                foreach ($_POST['checkbox'] as $value) {

                    $log = new log();
                    $log->setAccion($accion);
                    $log->setFecha($fecha);
                    $log->setUsuario($nombreUsuario);
                    $log->setNombre($value);

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($log);
                    $em->flush();
                   
                    shell_exec("govc vm.power -off -force /ha-datacenter/$value");
                }
            }
            
        }

        if (isset($_POST['encender'])) {

            $id = $this->getUser()->getId();
            $nombreUsuario = $this->getUser()->getEmail();;
            $accion = $_POST['encender'];
            $fecha =  date('m-d-Y h:i:s a', time()); 

            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");
          
            if (isset($_POST['checkbox'])) {

                foreach ($_POST['checkbox'] as $value) {

                    $log = new log();
                    $log->setAccion($accion);
                    $log->setFecha($fecha);
                    $log->setUsuario($nombreUsuario);
                    $log->setNombre($value);

                    $em = $this->getDoctrine()->getManager();

                    $em->persist($log);
                    $em->flush();
                 
                    shell_exec("govc vm.power -on /ha-datacenter/$value");
                }
            }
            
        }

        if (isset($_POST['descargar'])) {
                    $filename = "/home/miguel/credenciales.txt";
                    
                    if(file_exists($filename)) {
                        
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header("Cache-Control: no-cache, must-revalidate");
                        header("Expires: 0");
                        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
                        header('Content-Length: ' . filesize($filename));
                        header('Pragma: public');
                        flush();
                        readfile($filename);
                        die();
                        
                    } else {
                        echo "File does not exist.";
                    }
        }

        if (isset($_POST['eliminar'])) {

            $id = $this->getUser()->getId();
            $nombreUsuario = $this->getUser()->getEmail();;
            $accion = $_POST['eliminar'];
            $fecha =  date('m-d-Y h:i:s a', time()); 


            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

          
            if (isset($_POST['checkbox'])) {  
               
                foreach ($_POST['checkbox'] as $value) {

                    $log = new log();
                    $log->setAccion($accion);
                    $log->setFecha($fecha);
                    $log->setUsuario($nombreUsuario);
                    $log->setNombre($value);

                    $em = $this->getDoctrine()->getManager();
    
                    $em->persist($log);
                    $em->flush();

                    $vm = substr($value, 3);
                    $em = $this->getDoctrine()->getManager();
                    $query = $em->createQuery(
                        'DELETE App:Parametros n 
                        WHERE n.Nombre = :nombre'
                    )->setParameter("nombre", $vm);
                    $query->execute();
                        
                    shell_exec(" govc vm.destroy /ha-datacenter/$value");
                }
            }
            
        }

        if (isset($_POST['suspender'])) {
            
            $id = $this->getUser()->getId();
            $nombreUsuario = $this->getUser()->getEmail();;
            $accion = $_POST['suspender'];
            $fecha =  date('m-d-Y h:i:s a', time());  
            
            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");
          
            if (isset($_POST['checkbox'])) {
                
                foreach ($_POST['checkbox'] as $value) {

                    $log = new log();
                    $log->setAccion($accion);
                    $log->setFecha($fecha);
                    $log->setUsuario($nombreUsuario);
                    $log->setNombre($value);
                    
                    $em = $this->getDoctrine()->getManager();

                    $em->persist($log);
                    $em->flush();
                    
                    shell_exec("govc vm.power -suspend=true /ha-datacenter/$value");
                  
                }
            }
           
        }
    }
}
