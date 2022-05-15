<?php

/**
 * This class is the base Controller class
 */
Class Controller {
    
    function __construct() {
        $this->view = new View();
    }

    function isLogin(){
        if(!isset($_SESSION["token"]) || !isset($_COOKIES["token"]) ){
            header("Location:".URL."/main/login");
            exit();

        } elseif(($_SESSION["token"] != $_COOKIE["token"])){
            $this->error(401);
            exit();
        }
    }

    function isAdTe(){
        if($_SESSION['user']->getUser_type_id() == 2 || $_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            $this->error(401);
            die();
        }
    }

    function infoAdTe(){
        if($_SESSION['user']->getUser_type_id() == 2 || $_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            return false;
        }
    }

    function infoTeacher(){
        if($_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            return false;
        }
    }

    function infoAdmin(){
        if($_SESSION['user']->getUser_type_id() == 2){
            return true;
        } else {
            return false;
        }
    }

    function isAdmin(){
        if($_SESSION['user']->getUser_type_id() == 2){
            return true;
        } else {
            $this->error(401);
        }
    }
    
    function isTeacher(){
        if($_SESSION['user']->getUser_type_id() == 3){
            return true;
        } else {
            $this->error(401);
        }
    }

    function loadModel($model){
        $url = './Models/'.$model.'.php';
        //Check if the model name exist in the proyect
        if(file_exists($url)){
            require $url;
            return $this->$model = new $model();
        } else {
            die("Error, model not found: ".$url);
        }
    }

    function error($errorType = 400){
        switch($errorType){
            case 400:
                $this->view->render("/errors/400");
                break;
            case 401: 
                $this->view->render("/errors/401");
                break;
            case 404:
                $this->view->render("/errors/404");
                break;
        }
    }
}

?>