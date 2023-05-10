<?php

require_once('libs/imodel.php'); 

Class Model{
    
    function __construct(){
        $this->db = new Database();
    }

    // funcion para generar las consultas
    function query($query){
        return $this-> db -> conexion() ->query($query);
    }

    //funcion que va extraer la funcion anterior para poder renplazarlo cuando queramos  para insertar datos 
    function prepare($query){
        return $this->db -> conexion() -> prepare($query);
    }
}

?>