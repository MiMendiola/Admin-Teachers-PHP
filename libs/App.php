<?php
require_once './Controllers/Error.php';
/**
 * This class takes the value returned by the htaccess with the content of the URL
 * and parses it to separate it into the call to the object, then to its method and finally its parameters.
 */
Class App{

    function __construct(){

        //Read URL and divide
        $url = isset($_GET['url']) ? $_GET['url']: null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);

        //Enter without controller or withoud sey the method
        if((empty($url[0]) || $_GET['url'] == "main/login" || $_GET['url'] == "main/")){
                $fileController = './Controllers/main.php';
                require_once $fileController;
                $Controller = new Main();
                
                //Check if the session variable exists and if you have a valid token to move the user to the dashboard or login
                if(isset($_SESSION["token"]) && isset($_COOKIE["token"])){
                    if($_SESSION["token"] != $_COOKIE["token"]){
                        return $Controler->Errores(401);
                    } else {
                        header("Location:".URL."main/dashboard");
                    }
                } else {
                    $Controller->login();
                }
    
                return false;
            
        }
  
        $fileController = './Controllers/'.$url[0]. '.php';
        if(file_exists($fileController)){

            //Check if the user has a token or valid login
            if((!isset($_SESSION["token"]) || !isset($_COOKIE["token"])) && (!empty($url[0]) && $_GET['url'] != "main/login")){
                //We check if the method is ajax_login or ajax_forgot_pass if its true they can call teh method.
                if( $url[1] != "ajax_login"){
                    //if the method is not a ajax_forgot_pass continue

                    if($url[1] != "ajax_forgot_pass" && $url[1] != "createTeacherAccount" && $url[1] != "ajax_newTeacher"){
                        header("Location:".URL."main/login");
                        exit();
                    }
                }

            } elseif($_SESSION["token"] != $_COOKIE["token"]){
                return $Controler->Errores(401);
            }
            
            require_once $fileController;
            $Controller = new  $url[0];

            if(isset($url[1])){
                if(method_exists($Controller, $url[1])){
                    //We check if a parameter is passed by url
                    if(isset($url[2])){
                        if(isset($url[3])){
                            if(isset($url[4])){
                                $Controller->{$url[1]}($url[2], $url[3], $url[4]);
                            } else {
                                $Controller->{$url[1]}($url[2], $url[3]);
                            }
                        }else {
                            $Controller->{$url[1]}($url[2]);
                        }
                    } else {
                        $Controller->{$url[1]}();
                    }
                } else {
                    $Controller = new Controller();
                    $Controller->error();
                }
            } else {
                $Controller->{"index"}();
            }

        } else {
            $Controller = new Controller();
            $Controller->error(404);
        }
    }
}