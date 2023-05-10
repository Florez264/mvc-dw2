<?php

require_once('controllers/errores.php');


//aqui vamos a modificar la forma de solicitudes para rutear la solicitudes 
class App{
 
    function __construct(){
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url,'/'); // esto me permite borrar cualquier diagonal (/) que se encuentre ala final de una url
        $url = explode('/', $url);// con esta dividimos la URL que tenemos en un arreglo por cada diagonal que encuentre

        //validamos si no existe un url que en este caso es un areglo me redirija a el login
        if (empty($url[0])) {
            # code...
            $archivocontroller = 'controllers/login.php';
            require_once $archivocontroller;
            $controller = new Login();          //nueva extancia
            $controller -> loadModel('login');  // su modelo
            $controller -> render();
            return false;
        }

        //aqui pasamos la misma variable que va ser igual a controlador + URL en indice 0 
        //que tiene ser el nombre del controlador
        $archivocontroller = 'controllers/' . $url[0] .'.php';

         // validamos con condicional usando la funcion file_exists que valida si el archivo existe
        if (file_exists($archivocontroller)) {
            # code...
            require_once $archivocontroller; //aqui llamamos al archivo si existe 

            $controller = new $url[0];      // se crea una nueva estancia de ese modelo
            $controller ->loadModel($url[0]); // llamamos su modelo

            if (isset($url[1])) {
                if (method_exists($controller,$url[1])) {
                    if (isset($url[2])) {
                        # No de parametros
                        $nparam = count($url) - 2;
                        # arreglo de parametros
                        $nparam = [];
                        for ($i=0; $i < $nparam ; $i++) { 
                            array_push($nparam,$url[$i] + 2);
                        }
                        $controller -> {$url[1]}($nparam);
                    } else {
                        # No tiene parametro se manda a llamar el metodo tal cual
                        $controller -> {$url[1]}();
                    }
                    
                } else {
                    # Error no existe el metodo
                    $controller = new Errores();
                }
                
            } else {
                # No hay metodo a cargar, se carga el metodo por default
                $controller -> render();
            }
            
        } else {
            # no existe el archivo manda un errror
            $controller = new Errores(); 
        }
        
    }

}
?>