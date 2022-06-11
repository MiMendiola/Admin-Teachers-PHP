<?php

class Core
{
    function __construct()
    {

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

}