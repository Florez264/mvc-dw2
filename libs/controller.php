<?php
//este controlador va a cargar el modelo y la vista que deseemos presentar  de nuetra APP
class Controller{

    function __construct()
    {
        $this-> view = new View();
    }

    function loadModel($model){
        $url = 'model/'. $model . 'model.php'; //creamos una URL que busque en la en la ubicacion models/
         //validamos si exsite el archivo
        if (file_exists($url)) {
            require_once $url;

            $modelName = $model.'Model';
            $this->model = new $modelName();
        }
    }

     //funcion existPOST es para simplificar los exist y los post al momento de recibir parametros
    //para ingresar datos a la base de datos 
    function existPOST($params){
        foreach ($params as $param) {
            # code...
            if (!isset($_POST[$param])) {
                # code...
                error_log('CONTROLLER::existPOST => No existe el parametro'. $param);
                return false;
            }
        }
        return true;
    }
/** funcion para simplicar el GET  */
    function existGET($params){
        foreach ($params as $param) {
            if (!isset($_GET[$param])) {
                error_log('CONTROLLER::existGET => No existe el parametro'. $param);
                return false;
            }
        }
        error_log( "existGET: Existen parámetros" );
        return true;
    }

/**funcion para extraer los parametros del GET y POST */    
    function getGet($name){
        return $_GET[$name];
    }

    function getPost($name){
        return $_POST[$name];
    }

    /** esta funcion es para redirigir si todo esta corrector o hay algun error  */
    function redirect($url, $mensajes = []){
        $data = [];
        $params = '';
        
        foreach ($mensajes as $key => $value) {
            array_push($data, $key . '=' . $value);
        }
        $params = join('&', $data);
        
        if($params != ''){
            $params = '?' . $params;
        }
        header('location: ' . constant('URL') . $url . $params);
    }
 
}

?>