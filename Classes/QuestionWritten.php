<?php

class QuestionWritten extends Question {
    private $result;

    function __construct($id, $title, $question_type, $text, $result)
    {
        parent::__construct($id, $title, $question_type, $text);
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result): void
    {
        $this->result = $result;
    }

}