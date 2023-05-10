<?php

Class Dashboard extends SessionController{

    function __construct(){
        parent::__construct();
        
        error_log('Dashboard::constructor() -> Inicio de Dashboard');
    }

    function render(){
        error_log('Dashboard::render -> cargar el index de dashboard');
        $this->view->render('dashboard/index');
    }
}

?>