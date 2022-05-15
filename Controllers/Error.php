<?php
Class Errores extends Controller{
    
    /**
     * The constructor requires a number with the type of error or defaults to 400
     * @param int error type
     */
    function __construct($errorType = 400){
        parent::__construct();

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