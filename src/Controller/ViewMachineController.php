<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Parametros;


class ViewMachineController extends AbstractController
{
    /**
     * @Route("/view/machine", name="app_view_machine")
     */
    public function index(): Response {
        $this->conectarse();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $email = $this->getUser()->getEmail();
        $posicion = strpos($email, '@');
        $nombreUser = substr($email, 0, $posicion);
        $nombreacortado = substr($nombreUser, -6);
       
        putenv("GOVC_INSECURE=true");
        putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
        putenv("GOVC_DATASTORE=datastore1");
        putenv("GOVC_NETWORK=VM Network");

        $nombremaquina = shell_exec("govc find vm -name *".$nombreacortado."");

        if (empty($nombremaquina)) {
            $maquinas = NULL;
            $longitud = NULL;
        } else {
            $maquinas = explode("\n", $nombremaquina);
            $longitud = strlen($nombreacortado);
        }

        return $this->render('view_machine/index.html.twig', [
            'controller_name' => 'ViewMachineController',
            'maquina' => $maquinas,
            'lg'      => $longitud,
        ]);

    }

    public function conectarse () {
        if (isset($_POST['conectar'])) {
            $email = $this->getUser()->getEmail();
            $posicion = strpos($email, '@');
            $nombreUser = substr($email, 0, $posicion);
            $nombreacortado = substr($nombreUser, -6);
        
            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

            $nombremaquina = shell_exec("govc find vm -name *".$nombreacortado."");
            $maquinas = explode("\n", $nombremaquina);
            
            if (isset($_POST['checkbox'])) {
                foreach ($maquinas as $key => $value) {
              
                    if ($value == $_POST['checkbox']) {
                        $console =  shell_exec("govc vm.console /ha-datacenter/".$value);
                        $moid= $nombreacortado = substr(  $console, -3);
                        $number = $moid;
                        $url = "vmrc://global@192.168.1.38/?moid=$number";
                        $url2 = trim($url);
                        echo '<script>window.open ("'.$url2.'")</script>';
                    }
                }
            }
           
            
        }

        if (isset($_POST['apagar'])) {
            $email = $this->getUser()->getEmail();
            $posicion = strpos($email, '@');
            $nombreUser = substr($email, 0, $posicion);
            $nombreacortado = substr($nombreUser, -6);
        
            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

            $nombremaquina = shell_exec("govc find vm -name *".$nombreacortado."");
            $maquinas = explode("\n", $nombremaquina);
          
            if (isset($_POST['checkbox'])) {
                foreach ($maquinas as $key => $value) {
              
                    if ($value ==  $_POST['checkbox']) {
                        shell_exec("govc vm.power -off -force /ha-datacenter/$value");
                    }
                }
            }
            
        }

        if (isset($_POST['encender'])) {
            $email = $this->getUser()->getEmail();
            $posicion = strpos($email, '@');
            $nombreUser = substr($email, 0, $posicion);
            $nombreacortado = substr($nombreUser, -6);
        
            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

            $nombremaquina = shell_exec("govc find vm -name *".$nombreacortado."");
            $maquinas = explode("\n", $nombremaquina);
          
            if (isset($_POST['checkbox'])) {
                foreach ($maquinas as $key => $value) {
              
                    if ($value ==  $_POST['checkbox']) {
                        shell_exec("govc vm.power -on /ha-datacenter/$value");
                    }
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
            $email = $this->getUser()->getEmail();
            $posicion = strpos($email, '@');
            $nombreUser = substr($email, 0, $posicion);
            $nombreacortado = substr($nombreUser, -6);
        
            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

            $nombremaquina = shell_exec("govc find vm -name *".$nombreacortado."");
            $maquinas = explode("\n", $nombremaquina);
          
            if (isset($_POST['checkbox'])) {
                foreach ($maquinas as $key => $value) {
              
                    if ($value ==  $_POST['checkbox']) {
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
            
        }

        if (isset($_POST['suspender'])) {
            $email = $this->getUser()->getEmail();
            $posicion = strpos($email, '@');
            $nombreUser = substr($email, 0, $posicion);
            $nombreacortado = substr($nombreUser, -6);
        
            putenv("GOVC_INSECURE=true");
            putenv("GOVC_URL=https://root:Tt.676559546@192.168.1.38/sdk");
            putenv("GOVC_DATASTORE=datastore1");
            putenv("GOVC_NETWORK=VM Network");

            $nombremaquina = shell_exec("govc find vm -name *".$nombreacortado."");
            $maquinas = explode("\n", $nombremaquina);
          
            if (isset($_POST['checkbox'])) {

                 foreach ($maquinas as $key => $value) {
                    if ($value ==  $_POST['checkbox']) {
                        shell_exec("govc vm.power -suspend=true /ha-datacenter/$value");
                    }
                 }
            }
           
        }
    }
}
