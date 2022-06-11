<?php
Class Test  extends Core{
    private $id;
    private $hash;
    private $name;
    private $description;
    private $totalQuestions;
    private $questions = array();
    private $time;
    private $dateClose;
    private $userCreate;
    private $date;
    private $open;
    private $true_count;
    private $wrong_discount;
    private $random;
    private $user_test;

    function __construct($id, $hash, $name, $description, $totalQuestions, $date, $time, $dateClose, $open, $userCreate, $true_count,$wrong_discount, $random, $questions = [], $user_test){
        parent::__construct();
        $this->id = $id;
        $this->hash = $hash;
        $this->name = $name;
        $this->description = $description;
        $this->totalQuestions = $totalQuestions;
        $this->questions = $questions;
        $this->time = $time;
        $this->date = $date;
        $this->dateClose = $dateClose;
        $this->open = $open;
        $this->userCreate = $userCreate;
        $this->true_count = $true_count;
        $this->wrong_discount = $wrong_discount;
        $this->random = $random;
        $this->user_test = $user_test;
    }

    /**
     * @return mixed
     */
    public function getUserTest()
    {
        return $this->user_test;
    }

    /**
     * @param mixed $user_test
     */
    public function setUserTest($user_test): void
    {
        $this->user_test = $user_test;
    }

    /**
     * @return mixed
     */
    public function getTrueCount()
    {
        return $this->true_count;
    }

    /**
     * @param mixed $true_count
     */
    public function setTrueCount($true_count): void
    {
        $this->true_count = $true_count;
    }

    /**
     * @return mixed
     */
    public function getWrongDiscount()
    {
        return $this->wrong_discount;
    }

    /**
     * @param mixed $wrong_discount
     */
    public function setWrongDiscount($wrong_discount): void
    {
        $this->wrong_discount = $wrong_discount;
    }

    /**
     * @return mixed
     */
    public function getRandom()
    {
        return $this->random;
    }

    /**
     * @param mixed $random
     */
    public function setRandom($random): void
    {
        $this->random = $random;
    }

    /**
     * @return mixed
     */
    public function getUserCreate()
    {
        return $this->userCreate;
    }

    /**
     * @param mixed $userCreate
     */
    public function setUserCreate($userCreate)
    {
        $this->userCreate = $userCreate;
    }
    /**
     * @return mixed
     */
    public function getDateClose()
    {
        return $this->dateClose;
    }

    /**
     * @param mixed $dateClose
     */
    public function setDateClose($dateClose)
    {
        $this->dateClose = $dateClose;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }
    /**
     * @return int
     */
    public function getOpen()
    {
        return $this->open;
    }

    /**
     * @param mixed $open
     */
    public function setOpen($open)
    {
        $this->open = $open;
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
     * @return Question
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


    public function prueba(){
        $this->loadModel("login");
        return $this->login->getUsers();
    }
}

?>