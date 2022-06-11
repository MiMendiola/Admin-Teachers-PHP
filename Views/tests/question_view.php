<?php
?>

<h4 class="mb-2"><?php echo $question->getTitle() ?></h4>
<ul class="list-group">
    <li class="list-group-item active" aria-current="true"><h5> <?php echo $question->getText() ?></h5></li>

<?php
if($question->getQuestionType() == "written"){
?>
    <li class='border-0 list-group-item '>
        <input type='text'  name='question_r' id='question_r' class='bg-success form-control input-group-lg' value="<?php echo $question->getResult()[0]->getText()?>" data-type='0' aria-describedby='basic-addon1' disabled/>
    </li>
</div>
<?php
} else {
    if($question->getQUestionType() == "simple"){
?>
        <?php
        $rom = $question->getAnswers();
        shuffle($rom);
        foreach ($rom as $answer) {
            if($answer->isValue()){
                echo "<li class='border-0 list-group-item pl-5 bg-success'>";
                echo "&nbsp; <input class='form-check-input me-1' type='radio' value='' disabled checked>";
            } else {
                echo "<li class='border-0 list-group-item pl-5'>";
                echo "&nbsp; <input class='form-check-input me-1' type='radio' value='' disabled>";
            }
            echo "&nbsp; ". $answer->getText();
            echo "</li>";
        }
    } else {

        $rom = $question->getAnswers();
        shuffle($rom);
        foreach ($rom as $answer) {
            if ($answer->isValue()) {
                echo "<li class='border-0 list-group-item pl-5 bg-success'>";
                echo "&nbsp; <input class='form-check-input me-1' type='checkbox' value='' disabled checked>";
            } else {
                echo "<li class='border-0 list-group-item pl-5'>";
                echo "&nbsp; <input class='form-check-input me-1' type='checkbox' value='' disabled>";
            }
            echo "&nbsp; " . $answer->getText();
            echo "</li>";
        }

    }
}
        ?>
    </ul>
<?php

?>
