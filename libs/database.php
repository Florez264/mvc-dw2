<?php

class Database{
private $host;
private $db;
private $user;
private $password;
private $charset;

public function __construct()
{
 // al definir estas constante debemos definirlas en el archivo config donde vamos a configuar nuestra APP
    $this-> host = constant('HOST') ;
    $this-> db = constant('DB');
    $this-> user = constant('USER');
    $this-> password = constant('PASSWORD');
    $this-> charset = constant('CHARSET');
}

public function conexion()
{
    try{
        $connection = "mysql:host=" . $this->host . ";dbname=" . $this->db . ";charset=" . $this->charset;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $pdo = new PDO($connection, $this->user, $this->password, $options);
        return $pdo;
    }catch(PDOException $e){
        print_r('Error connection: ' . $e->getMessage());
    }
}
}

?>