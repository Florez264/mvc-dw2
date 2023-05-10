<?php

class Errores extends Controller{

    function __construct(){
        parent:: __construct();    
        error_log('Errores::construct -> inicio de errores');
        $this-> view -> render('error/index') ;
    }

    function render(){
        $this-> view -> render('error/index') ;
    } 
}

?>