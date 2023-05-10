<?php

require_once('model/usermodel.php');

Class Signup extends SessionController{

    function __construct(){
        parent::__construct();
    }

    function render(){
        $this->view->render('login/signup',[]);
    }

    function newUser(){
        if($this->existPOST(['username', 'password'])){
            
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            
            //validate data
            if($username == '' || empty($username) || $password == '' || empty($password)){
                // error al validar datos
                //$this->errorAtSignup('Campos vacios');
                $this->redirect('signup', ['error' => ErrorMenssages::ERROR_SIGNUP_NEWUSER_EMPTY]);
            }

            $user = new UserModel();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setRole("user");
            
            if($user->exists($username)){
                //$this->errorAtSignup('Error al registrar el usuario. Elige un nombre de usuario diferente');
                $this->redirect('signup', ['error' => ErrorMenssages::ERROR_SIGNUP_NEWUSER_EXISTS]);
                //return;
            }else if($user->save()){
                //$this->view->render('login/index');
                $this->redirect('', ['success' => SuccesMenssages::SUCCESS_SIGNUP_NEWUSER]);
            }else{
                /* $this->errorAtSignup('Error al registrar el usuario. Inténtalo más tarde');
                return; */
                $this->redirect('signup', ['error' => ErrorMenssages::ERROR_SIGNUP_NEWUSER]);
            }
        }else{
            // error, cargar vista con errores
            //$this->errorAtSignup('Ingresa nombre de usuario y password');
            $this->redirect('signup', ['error' => ErrorMenssages::ERROR_SIGNUP_NEWUSER_EXISTS]);
        }
    }
}

?>