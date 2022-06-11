<?php
    Class Model {

        function __construct(){
            $this->db = new Database();
        }

        function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }
        function userCourses($userId){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM user_course JOIN courses ON user_course.course_id = courses.course_id WHERE user_course.user_id = '".$userId."';");
                $query->execute();
                $returnQuery = array();
                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $test = $this->getTestForCourse($row['course_id']);
                        $students = $this->coursesUser($row['course_id']);
                        $creator = $this->getUserById( $row['user_create']);
                        $course = new Course($row['course_id'], $row['course_name'], $row['course_description'], $row['course_folder'], $creator, $test, $row['course_img'], $row['date_create'], $students, $row['open'], $row['hash']);
                        $returnQuery[]= $course;
                    }
                    return $returnQuery;
                } else {
                    return NULL;
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
        function getAnswers($question_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM answers WHERE question_id = '".$question_id."'");
                $query->execute();
                $resultQuery = array();
                if($query->rowCount() > 0 ){
                    while($row = $query->fetch()){
                        array_push($resultQuery, new Question($row['answer_id'], $row['answer_text'],  $row['answer_value'], $row['question_id']));
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

        function getTestForCourse($course_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM course_test INNER JOIN tests ON tests.test_id = course_test.test_id WHERE course_id = :course_id ");
                $query->execute(array(":course_id"=>$course_id));
                $resultQuery = array();
                while ($row = $query->fetch()){
                    $questions = $this->getTestQuestions($row['test_id']);
                    $user_test = $this->checkUserTest($row['test_id'], $_SESSION['user']->getUser_id());
                    $test = new Test($row['test_id'], $row['hash'],  $row['name'], $row['description'], $row['questions'], $row['date_open'],$row['time'], $row['dateClose'], $row['open'], $row['user_id'], $row["true_count"], $row["wrong_discount"], $row["random"], $questions, $user_test);
                    array_push($resultQuery, $test);
                }
                return $resultQuery;
            } catch (PDOException $ex){
                echo $ex->getMessage();
                return NULL;
            }
        }

        function getUserById($id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users WHERE user_id = :id");
                $query->execute(array(':id'=> $id));
                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $user = new User($row['user_id'], $row['name'],$row['last_name'],$row['passport'],$row['email'],$row['pass'],$row['normal_ip'],$row['hash'],$row['photo'],$row['user_type_id'], $row['first_time'], $row['open_acount']);
                    }
                    return $user;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function checkUserTest($test_id, $user_id){
            try{
                $query = $this->db->connect()->prepare("SELECT * FROM user_test WHERE test_id='".$test_id."' AND user_id='".$user_id."'");
                $query->execute();
                $selectQuery = array();
                if($query->rowCount() == 1 ){
                    while ($row = $query->fetch()){
                        $selectQuery["relation_id"] = $row['relation_id'];
                        $selectQuery["user"] = $this->getUserById($row['user_id']);
                        $selectQuery['date_start'] = $row['date_start'];
                        $selectQuery['date_end'] = $row['date_end'];
                        $selectQuery['ip_conect'] = $row['ip_conect'];
                        $selectQuery['cheats'] = $row['cheats'];
                        $selectQuery['score'] = $row['score'];
                    }
                    return $selectQuery;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getTestById($id){
            $query = $this->db->connect()->prepare("SELECT * FROM tests WHERE test_id = '".$id."';");
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

    }
?>