<?php

class Question {
    private $id;
    private $title;
    private $question_type;
    private $text;
    private $student_answer = "";

    function __construct($id, $title, $question_type, $text) {
        $this->id = $id;
        $this->title = $title;
        $this->question_type = $question_type;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getStudentAnswer()
    {
        return $this->student_answer;
    }

    /**
     * @param string $student_answer
     */
    public function setStudentAnswer($student_answer)
    {
        $this->student_answer = $student_answer;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getQuestionType()
    {
        return $this->question_type;
    }

    /**
     * @param mixed $question_type
     */
    public function setQuestionType($question_type): void
    {
        $this->question_type = $question_type;
    }

    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }




}