<?php
$half = BASENOTE/2;
if($test->getUserTest()['score'] > $half){
    $bg = "text-success";
}elseif($test->getUserTest()['score'] < $half){
    $bg = "text-danger";
}else{
    $bg = "text-warning";
}
?>

<div class="text-center">
    <h3 class="text-primary"><?php echo $user->fullName()." - ".$test->getName() ?> Review</h3>
    <h4 class=" font-weight-bold <?php echo $bg ; ?>"><?php echo " Score: ".$test->getUserTest()['score']."/".BASENOTE ?> </h4>
</div>

    <div class="card p-4 col-md-10 m-auto">
        <div class="card-body">
            <?php
            $count = 0;
            foreach($test->getQuestions() AS $question){
                $count++;
                ?>
                <div class="row">
                    <div class="col-md-1 rounded ">
                        <h4 class="p-2"><?php echo $count ?></h4>
                    </div>
                    <div class="col-md-11 m-0 pl-1">
                        <ul class="list-group pb-5">
                            <li class="list-group-item active" aria-current="true"><h5> <?php echo $question->getText() ?></h5></li>
                            <?php
                            switch ($question->getQuestionType()){
                                case "multiple":
                                    $valuesA = array();

                                    if(!empty($question->getStudentAnswer())){
                                        foreach ($question->getStudentAnswer() AS $userAnswer){
                                            array_push($valuesA, $userAnswer->getId());
                                        }
                                    }

                                    $rom = $question->getAnswers();
                                    foreach ($rom as $answer) {

                                        if($answer->isValue()){
                                            if(!empty($question->getStudentAnswer())){
                                                if(in_array($answer->getId(), $valuesA)){
                                                    echo "<li class='border-0 list-group-item pl-5 bg-success'>";
                                                    echo "&nbsp; <input class='form-check-input me-1 check' type='checkbox' checked disabled>";
                                                } else {
                                                    echo "<li class='border-0 list-group-item pl-5 bg-warning'>";
                                                    echo "&nbsp; <input class='form-check-input me-1 check' type='checkbox' disabled>";
                                                }
                                            } else {
                                                echo "<li class='border-0 list-group-item pl-5 bg-success'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='checkbox' disabled>";
                                            }
                                        } else {
                                            if(!empty($question->getStudentAnswer())){
                                                if(in_array($answer->getId(), $valuesA)){
                                                    echo "<li class='border-0 list-group-item pl-5 bg-danger'>";
                                                    echo "&nbsp; <input class='form-check-input me-1 check' type='checkbox' checked disabled>";
                                                } else {
                                                    echo "<li class='border-0 list-group-item pl-5'>";
                                                    echo "&nbsp; <input class='form-check-input me-1 check' type='checkbox' disabled>";
                                                }
                                            }
                                            else {
                                                echo "<li class='border-0 list-group-item pl-5'>";
                                                echo "&nbsp; <input class='form-check-input me-1 ' type='checkbox' disabled>";
                                            }
                                        }

                                        echo "&nbsp; " . $answer->getText();
                                        echo "</li>";
                                    }
                                    break;
                                case "simple":
                                    $rom = $question->getAnswers();
                                    foreach ($rom as $answer) {
                                        if(empty($question->getStudentAnswer())){
                                            if($answer->isValue()){
                                                echo "<li class='border-0 list-group-item pl-5 bg-success'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='radio' disabled>";
                                            } else {
                                                echo "<li class='border-0 list-group-item pl-5'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='radio' disabled>";
                                            }
                                        }elseif($question->getStudentAnswer()->getId() == $answer->getId()){
                                            if($question->getStudentAnswer()->isValue()){
                                                echo "<li class='border-0 list-group-item pl-5 bg-success'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='radio' checked disabled>";
                                            } else {
                                                echo "<li class='border-0 list-group-item pl-5 bg-danger'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='radio'  checked disabled>";
                                            }
                                        } else {
                                            if($answer->isValue()){
                                                echo "<li class='border-0 list-group-item pl-5 bg-success'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='radio' disabled>";
                                            } else {
                                                echo "<li class='border-0 list-group-item pl-5'>";
                                                echo "&nbsp; <input class='form-check-input me-1 check' type='radio' disabled>";
                                            }
                                        }


                                        echo "&nbsp; " . $answer->getText();
                                        echo "</li>";
                                    }
                                    break;
                                case "written":
                                    if(empty($question->getStudentAnswer())){
                                        echo  "<li class='border-0 pt-4 list-group-item '>";
                                        echo     "<input type='text' class='form-control input-group-lg' value='".$question->getResult()[0]->getText()."'  disabled/>";
                                        echo  "</li>";
                                    } elseif($question->getResult()[0]->getText() == $question->getStudentAnswer()){
                                        echo  "<li class='border-0 pt-4 list-group-item'>";
                                        echo     "<input type='text' class='form-control input-group-lg bg-success' value='".$question->getStudentAnswer()."'  disabled/>";
                                        echo  "</li>";
                                    } else {
                                        echo  "<li class='border-0 pt-4 list-group-item '>";
                                        echo     "<input type='text' class='form-control input-group-lg bg-danger' value='".$question->getStudentAnswer()."'  disabled/>";
                                        echo  "</li>";
                                    }
                                    break;
                            }
                            ?>
                        </ul>
                    </div>

                </div>


                <?php
            }
            ?>
            <div class="card-footer text-center">
                <a href="<?php echo $return ?>" class="btn btn-primary"> Return</a>
            </div>
        </div>
</div>

