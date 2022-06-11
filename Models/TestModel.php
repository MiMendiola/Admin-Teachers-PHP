<?php
    Class TestModel extends Model{
        function __construct(){
            parent::__construct();
        }

        function saveTest($name, $hash, $description, $questions, $date_open, $dateClose, $time, $courses, $true_count, $wrong_discount, $random){
            try {
                if(!$this->testBack($hash)){
                    echo "The Test exist on the DB. You can't create duplicates.";

                    return false;
                }
                 $query = $this->db->connect()->prepare("INSERT INTO tests (name, hash, description, questions, date_open, dateClose, time, user_id, true_count, wrong_discount, random ) VALUES(:name, :hash, :description, :questions, :date_open, :dateClose, :time, :user_id, :true_count, :wrong_discount, :random)");
                if($query->execute(array(":name"=>$name, ":hash"=>$hash, ":description"=>$description, ":questions"=> $questions, ":date_open"=>$date_open, ":dateClose"=>$dateClose, ":time"=>$time, ":user_id"=>$_SESSION['user']->getUser_id(), ":true_count"=>$true_count, ":wrong_discount"=>$wrong_discount, ":random"=>$random)) ){
                    $test = $this->getNowTest();
                    if(is_array($courses)){
                        foreach($courses as $course_id){
                            $this->saveRelationCoursesTest($test->getId(), $course_id);
                        }
                    } else {
                        $this->saveRelationCoursesTest($test->getId(), $courses);
                    }
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getTestByHash($hash){
            $query = $this->db->connect()->prepare("SELECT * FROM tests WHERE hash = '".$hash."'");
            $query->execute();
            if($query->rowCount() == 1){
                while ($row = $query->fetch()){
                    $questions = $this->getTestQuestions($row['test_id']);
                    $user_test = $this->checkUserTest($row['test_id'], $_SESSION['user']->getUser_id());

                    return $test = new Test($row['test_id'], $row['hash'],  $row['name'], $row['description'], $row['questions'], $row['date_open'],$row['time'], $row['dateClose'], $row['open'], $row['user_id'], $row["true_count"], $row["wrong_discount"], $row["random"], $questions, $user_test);
                }
            }
            return false;
        }

        function getNowTest(){
            try{
                $query = $this->db->connect()->prepare("SELECT MAX(test_id) AS test_id, name, description, questions, date_open, time, open, hash, dateClose, user_id, true_count, wrong_discount, random FROM tests");
                $query->execute();
                if($query->rowCount() == 1 ){
                    while($row = $query->fetch()){
                        $questions = $this->getTestQuestions($row['test_id']);
                        $user_test = $this->checkUserTest($row['test_id'], $_SESSION['user']->getUser_id());

                        $test = new Test($row['test_id'], $row['hash'],  $row['name'], $row['description'], $row['questions'], $row['date_open'],$row['time'], $row['dateClose'], $row['open'], $row['user_id'], $row["true_count"], $row["wrong_discount"], $row["random"], $questions, $user_test);
                    }
                    return $test;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function testBack($hash){
            $query = $this->db->connect()->prepare("SELECT hash FROM tests WHERE hash = '".$hash."';");
            $query->execute();
            if($query->rowCount() == 1){
                return false;
            }
            return true;
        }

        function saveRelationCoursesTest($id_test, $id_course){
            $query = $this->db->connect()->prepare("INSERT INTO course_test (test_id, course_id) VALUES(:id_test, :id_course)");
            if($query->execute(array(":id_test"=>$id_test, ":id_course"=>$id_course))){
                return true;
            } else {
                return false;
            }
        }

        function createQuestion($title, $question_type, $question_text, $answerTrue, $answerFalse, $question_d){
            try{
                $query = $this->db->connect()->prepare("INSERT INTO questions (title, question_type, question_text) VALUES(:title, :question_type, :question_text)");
                if($query->execute(array(":title"=>$title, ":question_type"=>$question_type, ":question_text"=>$question_text))){
                    $question = $this->getLastInsertQuestion();
                    //Create realtion Course and Answers
                    if($question_type == "written"){
                        $this->answers($question->getId(), $question_d, 1);
                    } else {
                        foreach ($answerTrue AS $true){
                            $this->answers($question->getId(), $true, 1);
                        }
                        foreach($answerFalse AS $false){
                            $this->answers($question->getId(), $false, 0);
                        }
                    }
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getLastInsertQuestion(){
            try{
                $query = $this->db->connect()->prepare("SELECT MAX(question_id ) AS question_id , title, question_type, question_text FROM questions");
                $query->execute();
                if($query->rowCount() == 1 ){
                    while($row = $query->fetch()){
                        $question = new Question($row['question_id'], $row['title'],  $row['question_type'], $row['question_text']);
                    }
                    return $question;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function answers($question_id, $answer_text, $answer_value){
            try{
                $query = $this->db->connect()->prepare("INSERT INTO answers (answer_text, answer_value, question_id) VALUES(:answer_text, :answer_value, :question_id)");
                if($query->execute(array(":answer_text"=>$answer_text, ":answer_value"=>$answer_value, ":question_id"=>$question_id))){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getQuestions(){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM questions");
                $query->execute();
                $resultQuery = array();
                if($query->rowCount() > 0 ){
                    while($row = $query->fetch()){
                        $answers = $this->getAnswers($row['question_id']);
                        $question = new QuestionSimple($row['question_id'], $row['title'],  $row['question_type'], $row['question_text'], $answers);
                        array_push($resultQuery, $question);
                    }
                    return $resultQuery;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getQuestion($question_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM questions WHERE question_id='".$question_id."'");
                $query->execute();
                $resultQuery = array();
                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $answers = $this->getAnswers($row['question_id']);
                        switch ($row['question_type']){
                            case "simple":
                                $question = new QuestionSimple($row['question_id'], $row['title'],  $row['question_type'], $row['question_text'], $answers);
                                break;
                            case "multiple":
                                $question = new QuestionMultiple($row['question_id'], $row['title'],  $row['question_type'], $row['question_text'], $answers);
                                break;
                            case "written":
                                $question = new QuestionWritten ($row['question_id'], $row['title'],  $row['question_type'], $row['question_text'], $answers);
                                break;
                        }
                       return $question;
                    }
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getAnswers($question_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM answers WHERE question_id = '".$question_id."'");
                $query->execute();
                $resultQuery = array();
                if($query->rowCount() > 0 ){
                    while($row = $query->fetch()){
                        array_push($resultQuery, new Answer($row['answer_id'], $row['answer_text'],  $row['answer_value'], $row['question_id']));
                    }
                    return $resultQuery;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
        function getAnswer($answer_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM answers WHERE answer_id = '".$answer_id."'");
                $query->execute();
                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $answer = new Answer($row['answer_id'], $row['answer_text'],  $row['answer_value'], $row['question_id']);
                    }
                    return $answer;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function addQuestionTest($test_id, $question_id){
            try{
                $query = $this->db->connect()->prepare("INSERT INTO test_questions (test_id, question_id ) VALUES(:test_id, :question_id)");
                if($query->execute(array(":question_id"=>$question_id, ":test_id"=>$test_id))){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getTestQuestions($test_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM test_questions WHERE test_id='".$test_id."'");
                $query->execute();
                $resultQuery = array();
                if($query->rowCount() > 0 ){
                    while($row = $query->fetch()){
                        $question = $this->getQuestion($row['question_id']);
                        array_push($resultQuery, $question);
                    }
                    return $resultQuery;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function removeQuestionTest($test_id, $question_id){
            try{
                $query = $this->db->connect()->prepare("DELETE FROM test_questions WHERE test_id = :test_id AND question_id = :question_id");
                if($query->execute(array(":question_id"=>$question_id, ":test_id"=>$test_id))){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        //Si eliminas un test limpia las relaciones con el test
        function removeTestQuestions($test_id){
            try{
                $query = $this->db->connect()->prepare("DELETE FROM test_questions WHERE test_id = :test_id ");
                if($query->execute(array(":test_id"=>$test_id))){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
        function removeTestCourse($test_id){
            try{
                $query = $this->db->connect()->prepare("DELETE FROM test_questions WHERE test_id = :test_id ");
                if($query->execute(array(":test_id"=>$test_id))){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
        function removeTest($test_id){
            try{
                $query = $this->db->connect()->prepare("DELETE FROM tests WHERE test_id = :test_id");
                if($query->execute(array(":test_id"=>$test_id))){
                    $this->removeTestQuestions($test_id);
                    $this->removeTestCourse($test_id);

                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
        function checkTestScore($test_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM user_test WHERE test_id='".$test_id."'");
                $query->execute();
                if($query->rowCount() != 0 ){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
        //Comprueba si la pregunta se encuentra en un test.
        function checkQuestionTest($question_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM test_questions WHERE question_id='".$question_id."'");
                $query->execute();
                if($query->rowCount() != 0 ){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
        function removeQuestion($question_id){
            try{
                $query = $this->db->connect()->prepare("DELETE FROM questions WHERE question_id = :question_id");
                if($query->execute(array(":question_id"=>$question_id))){
                    $this->removeQuestionRelationAnswer($question_id);
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function removeQuestionRelationAnswer($question_id){
            try{
                $query = $this->db->connect()->prepare("DELETE FROM answers WHERE question_id = :question_id");
                if($query->execute(array(":question_id"=>$question_id))){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function openTest($test_id, $status){
            $realStatus = 0;
            if($status == "true"){
                $realStatus = 1;
            }

            try {
                $query = $this->db->connect()->prepare("UPDATE tests SET open =".$realStatus."  WHERE test_id ='".$test_id."';");
                if($query->execute()){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                return $e->getMessage();
            }
        }

        function getNewOportuniy($test_id, $user_id){
            try {
                $query = $this->db->connect()->prepare("UPDATE user_test SET date_start ='NULL' WHERE test_id ='".$test_id."' AND user_id='".$user_id."' ;");
                if($query->execute()){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                return $e->getMessage();
            }
        }

        function updateCheats($test_id, $user_id, $text){
            try {
                $query = $this->db->connect()->prepare("UPDATE user_test SET cheats ='".$text."' WHERE test_id ='".$test_id."' AND user_id='".$user_id."' ;");
                if($query->execute()){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                return $e->getMessage();
            }
        }

        function updateUserFinish($test_id, $user_id, $score, $dateEnd){
            try {
                $query = $this->db->connect()->prepare("UPDATE user_test SET score='".$score."', date_end='".$dateEnd."'  WHERE test_id ='".$test_id."' AND user_id='".$user_id."' ;");
                if($query->execute()){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        function saveSerializeTest($test_id, $user_id, $test){
            try {
                $serializedObject = serialize($test);
                $query = $this->db->connect()->prepare("UPDATE user_test  SET test_serialize = ? WHERE test_id =".$test_id." AND user_id=".$user_id);
                $query->execute(array($serializedObject));

            } catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        function getSerializeTest($test_id, $user_id){
            $query = $this->db->connect()->prepare("SELECT test_serialize FROM user_test WHERE test_id =".$test_id." AND user_id=".$user_id);
            $query->execute();
            if($query->rowCount() == 1){
                while ($row = $query->fetch()){
                $test = unserialize($row['test_serialize']);
                return $test;
                }
            }
            return false;
        }

        function userStartTest($test_id, $user_id, $date, $ip){
            try{
                $query = $this->db->connect()->prepare("INSERT INTO user_test (user_id, test_id, date_start, ip_conect) VALUES(:user_id, :test_id, :date_start, :ip_conect)");
                if($query->execute(array(":user_id"=>$user_id, ":test_id"=>$test_id, ":date_start"=>$date, ":ip_conect"=>$ip))){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function checkTestStatus($test_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM user_test WHERE test_id='".$test_id."'");
                $query->execute();
                $result = array();
                $selectQuery = array();
                if($query->rowCount() > 0 ){
                    while ($row = $query->fetch()){
                        $selectQuery["relation_id"] = $row['relation_id'];
                        $selectQuery["user"] = $this->getUserById($row['user_id']);
                        $selectQuery['date_start'] = $row['date_start'];
                        $selectQuery['date_end'] = $row['date_end'];
                        $selectQuery['ip_conect'] = $row['ip_conect'];
                        $selectQuery['cheats'] = $row['cheats'];
                        $selectQuery['score'] = $row['score'];
                        array_push($result, $selectQuery);
                    }
                    return $result;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
    }
?>