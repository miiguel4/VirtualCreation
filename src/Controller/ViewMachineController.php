<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $maquinas = explode("\n", $nombremaquina);

        return $this->render('view_machine/index.html.twig', [
            'controller_name' => 'ViewMachineController',
            'maquina' => $maquinas,
            
        ]);

    }

    public function conectarse() {
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
          

            foreach ($maquinas as $key => $value) {
              
                if ($value ==  $_POST['nombre']) {
                    $console =  shell_exec("govc vm.console /ha-datacenter/".$value);
                    $moid= $nombreacortado = substr(  $console, -3);
                    $number = $moid;
                    $url = "vmrc://global@192.168.1.38/?moid=$number";
                    $url2 = trim($url);
                    echo '<script>window.open ("'.$url2.'")</script>';
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
          

            foreach ($maquinas as $key => $value) {
              
                if ($value ==  $_POST['nombre']) {
                    shell_exec("govc vm.power -off -force /ha-datacenter/$value");
                    /* echo "govc vm.power -off -force /ha-datacenter/$value"; */
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
          

            foreach ($maquinas as $key => $value) {
              
                if ($value ==  $_POST['nombre']) {
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
    }
}