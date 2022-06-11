<?php

class Answer {
    private $id;
    private $text;
    private $value;
    private $question_id;

    function __construct($id, $text, $value, $question_id) {
        $this->id = $id;
        $this->text = $text;
        if($value == 0){
            $this->value = false;
        } else {
            $this->value = true;
        }
        $this->question_id = $question_id;
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

    /**
     * @return bool
     */
    public function isValue(): bool
    {
        return $this->value;
    }

    /**
     * @param bool $value
     */
    public function setValue(bool $value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestionId($question_id): void
    {
        $this->question_id = $question_id;
    }


}