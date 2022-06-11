<?php

class QuestionSimple extends Question {
    private $answers;
    public function __construct($id, $title, $question_type, $text, $answers)
    {
        parent::__construct($id, $title, $question_type, $text);
        $this->answers = $answers;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     */
    public function setAnswers($answers): void
    {
        $this->answers = $answers;
    }


}