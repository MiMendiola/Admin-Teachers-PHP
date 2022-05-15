<?php
Class Test {
    private $id;
    private $name;
    private $description;
    private $totalQuestions;
    private $questions = array();
    private $score;
    private $time;
    private $date;

    function __construct($id, $name, $description, $totalQuestions, $date, $time,$questions = [], $score = "" ){
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->totalQuestions = $totalQuestions;
        $this->totalQuestions = $questions;
        $this->score = $score;
        $this->time = $time;
        $this->date = $date;

    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of totalQuestions
     */ 
    public function getTotalQuestions()
    {
        return $this->totalQuestions;
    }

    /**
     * Set the value of totalQuestions
     *
     * @return  self
     */ 
    public function setTotalQuestions($totalQuestions)
    {
        $this->totalQuestions = $totalQuestions;

        return $this;
    }

    /**
     * Get the value of questions
     */ 
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set the value of questions
     *
     * @return  self
     */ 
    public function setQuestions($questions)
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * Get the value of score
     */ 
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the value of score
     *
     * @return  self
     */ 
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get the value of date
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of date
     *
     * @return  self
     */ 
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}

?>