<?php

class QuestionMultiple extends Question {
    private $answers;
    function __construct($id, $title, $question_type, $text, $answers) {
        parent::__construct($id, $title, $question_type, $text);
        $this->answers = $answers;
    }

    /**
     * @return Answer
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param Answer $answers
     */
    public function setAnswers($answers): void
    {
        $this->answers = $answers;
    }



}