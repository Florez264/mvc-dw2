<?php

Class SuccesMenssages{
    
    const SUCCESS_ADMIN_NEWCATEGORY_EXISTS  = "1f8f0ae8963b16403c3ec9ebb851f156s";
    const SUCCESS_SIGNUP_NEWUSER       = "8281e04ed52ccfc13820d0f6acb0985a";

    private $successList = [];

    function __construct(){
        $this->successList = [
            SuccesMenssages::SUCCESS_ADMIN_NEWCATEGORY_EXISTS => 'El nombre de la categoría ya existe, intenta otra',
            SuccesMenssages::SUCCESS_SIGNUP_NEWUSER => "Usuario registrado correctamente"
        ];
    }

    public function get($hash){ 
        return $this->successList[$hash];
    }

    public function existsKey($key){
        if(array_key_exists($key, $this->successList)){
            return true;
        }else{
            return false;
        }
    }
}

?>