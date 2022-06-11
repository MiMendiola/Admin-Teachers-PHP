<?php

Class Course {
    private $course_id;
    private $name;
    private $description;
    private $folder;
    private $user_create;
    private $tests;
    private $img;
    private $date_create;
    private $students;
    private $open;
    private $hash;

    function __construct($course_id, $name, $description, $folder, $user_create, $tests =[], $img = './assets/img/coursesImg/default.png', $date_create, $students=[], $open, $hash)
    {
        $this->course_id = $course_id;
        $this->name = $name;
        $this->description = $description;
        $this->folder = $folder;
        $this->user_create = $user_create;
        $this->tests = $tests;
        $this->img = $img;
        $this->date_create = $date_create;
        $this->students = $students;
        $this->open =$open;
        $this->hash = $hash;
    }

    
        function getCourse_id(){
            return $this->course_id;
        }
        function getName (){
            return $this->name;
        }
        function getDescription (){
            return $this->description;
        }
        function getFolder (){
            return $this->folder;
        }
        function getUser_create (){
            return $this->user_create;
        }
        function getTests (){
            return $this->tests;
        }
        function getImg (){
            return $this->img;
        }
        function getDate_create (){
            return $this->date_create;
        }

        function getStudents (){
            return $this->students;
        }



    /**
     * Get the value of open
     */ 
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * Set the value of open
     *
     * @return  self
     */ 
    public function setOpen($open)
    {
        $this->open = $open;

        return $this;
    }

    /**
     * Get the value of hash
     */ 
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set the value of hash
     *
     * @return  self
     */ 
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }
}


?>