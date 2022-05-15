<?php

    Class TestController  extends Controller{

        function __construct(){
            parent::__construct();
            $this->breadcrumbs = "<a href='".URL."main/dashboard'>Dashboard</a> /";
        }

        function index(){ 
            header("Location:".URL);
            exit();
        }

        function createTest(){
            if($test = "no terminado"){}
            $this->loadModel("admin");
           
            $data['view'] = "file_manager";
            $data['breadcrumbs'] = $this->breadcrumbs .= " File Manager /";
            $data['courses'] =  $this->admin->getCourses();

            $this->view->view_loader($data);    
        }

        function saveTest(){
            $this->loadModel("testModel");
            $this->testModel->saveTest($_POST["name"], $_POST["description"], $_POST["questions"], $_POST["date_open"], $_POST["time"], $_POST["courses"]);

        }

        function setTest($test_id){

        }

    }

?>