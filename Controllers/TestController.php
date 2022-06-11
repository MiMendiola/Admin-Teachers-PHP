<?php

    Class TestController extends Controller{

        function __construct(){
            parent::__construct();
            $this->breadcrumbs = "<a href='".URL."main/dashboard'>Dashboard</a> /";
        }

        function index(){ 
            header("Location:".URL);
            exit();
        }

        function createTest(){
            $this->loadModel("admin");
            $this->isAdTe();

            $data['view'] = "tests/create_test";
            $data['breadcrumbs'] = $this->breadcrumbs .= " Create a Test /";
            $data['courses'] =  $this->admin->getCourses();

            $this->view->view_loader($data);    
        }

        function saveTest(){
            $this->loadModel("testModel");
            $this->loadModel("admin");

            $hash = md5(date("Y-m-d H:i:s"));
            $random = 0;
            if(isset($_POST['random'])){
                $random = 1;
            }

            $course = $this->admin->getCourseId($_POST['courses'][0]);
            $this->testModel->saveTest($_POST["name"], $hash, $_POST["description"], $_POST["questions"], $_POST["date_open"],$_POST['dateClosed'], $_POST["time"], $_POST["courses"], $_POST["true_count"], $_POST["wrong_discount"], $random);
            header("Location:".URL."TestController/editTest/".$course->getHash()."/".$hash);
            exit();
        }

        function editTest($course_hash, $hash){
            $this->loadModel("admin");
            $this->loadModel("testModel");
            $this->isAdTe();

            $test = $this->testModel->getTestByHash($hash);
            $course = $this->admin->getCourseHash($course_hash);
            $testQuestions = $test->getQuestions();
            $totalQuestions = $this->testModel->getQuestions();
            $idQuestions = array();
            if(!is_null($testQuestions)){
                foreach ($testQuestions AS $question){
                    array_push($idQuestions, $question->getId());
                }
            }

            $questions = array();
            if(!is_null($totalQuestions)){
                foreach ($totalQuestions AS $question){
                    if(!in_array($question->getId(), $idQuestions)){
                        array_push($questions, $question);
                    }
                }
            }

           // $questions =  array_merge($this->testModel->getQuestions(), $test->getQuestions());
          //  $questions = $this->testModel->getQuestions();
            $data['breadcrumbs'] = $this->breadcrumbs .= "<a href='".URL."CourseController/managerCourse/".$course->getHash()."' title='Course management'> ".$course->getName()."</a> "." / ". $test->getName() ." /";
            $data['hash'] = $hash;
            $data['course'] = $course;
            $data['questions'] = $questions;
            $data['test'] = $test;
            $data['view'] = "tests/test_management";
            $this->view->view_loader($data);
        }

        function ajax_createQuestion(){
            $title = $_POST['title'];
            $question_type =$_POST['question_type'];
            $description = $_POST['description'];
            $answerTrue ="";
            $answerFalse = "";
            $question_d = "";
            if($question_type == "written"){
                $question_d = $_POST['question_d'];
            } else {
                $answerTrue = $_POST['answerTrue'];
                $answerFalse = $_POST['answerFalse'];
            }

            $this->loadModel("testModel");
            $status = $this->testModel->createQuestion($title, $question_type, $description, $answerTrue, $answerFalse, $question_d);
            if($status){
                $result = array( "status" => "true", "message" =>"New Question was created." );
                echo json_encode($result);
                return true;
            }
            $result = array( "status" => "ERROR", "message" =>"An error ocurred to create a new question.");
            echo json_encode($result);
            return false;
        }

        function ajax_addQuestionTest(){
            $this->loadModel("testModel");
            $question_id = $_POST['question_id'];
            $test_id = $_POST['test_id'];

            $haveScores = $this->testModel->checkTestScore($test_id);
            $test = $this->testModel->getTestById($test_id);

            if($haveScores){
                $result = array( "status" => "ERROR", "message" =>"Test can't be modify after students have taken it." );
                echo json_encode($result);
                return false;
            }

            if($test->getOpen() == 1){
                $result = array( "status" => "ERROR", "message" =>"Test is open, you can't be modify. Please close the test if you want modify" );
                echo json_encode($result);
                return false;
            }

            $status = $this->testModel->addQuestionTest($test_id, $question_id);
            if($status){
                $result = array( "status" => "true", "message" =>"New Question was created." );
                echo json_encode($result);
                return true;
            }
            $result = array( "status" => "ERROR", "message" =>"An error ocurred to create a new question.");
            echo json_encode($result);
            return false;
        }

        function ajax_removeQuestionTest(){
            $this->loadModel("testModel");
            $question_id = $_POST['question_id'];
            $test_id = $_POST['test_id'];
            $haveScores = $this->testModel->checkTestScore($test_id);
            $test = $this->testModel->getTestById($test_id);

            if($haveScores){
                $result = array( "status" => "ERROR", "message" =>"Test can't be modify after students have taken it." );
                echo json_encode($result);
                return false;
            }

            if($test->getOpen() == 1){
                $result = array( "status" => "ERROR", "message" =>"Test is open, you can't be modify. Please close the test if you want modify" );
                echo json_encode($result);
                return false;
            }

            $status = $this->testModel->removeQuestionTest($test_id, $question_id);
            if($status){
                $result = array( "status" => "true", "message" =>"The Question was deleted." );
                echo json_encode($result);
                return true;
            }
            $result = array( "status" => "ERROR", "message" =>"An error ocurred to delete a question.");
            echo json_encode($result);
            return false;
        }

        function ajax_deleteTest(){
            $this->loadModel("testModel");
            $test_id = $_POST['test_id'];
            $haveScores = $this->testModel->checkTestScore($test_id);

            if($haveScores){
                $result = array( "status" => "ERROR", "message" =>"Test can't be deleted after students have taken it." );
                echo json_encode($result);
                return false;
            }

            $status = $this->testModel->removeTest($test_id);
            if($status){
                $result = array( "status" => "true", "message" =>"The Test was deleted." );
                echo json_encode($result);
                return true;
            }
            $result = array( "status" => "ERROR", "message" =>"An error ocurred to delete a Test.");
            echo json_encode($result);
            return false;
        }

        function ajax_removeQuestion(){
            $this->loadModel("testModel");
            $question_id = $_POST['question_id'];
            $questionInTest = $this->testModel->checkQuestionTest($question_id);

            if($questionInTest){
                $result = array( "status" => "ERROR", "message" =>"You cannot delete a question that is in a test." );
                echo json_encode($result);
                return false;
            }

            $status = $this->testModel->removeQuestion($question_id);
            if($status){
                $result = array( "status" => "true", "message" =>"The Test was deleted." );
                echo json_encode($result);
                return true;
            }
            $result = array( "status" => "ERROR", "message" =>"An error ocurred to delete a Test. ".$status);
            echo json_encode($result);
            return false;
        }

        function ajax_questionView(){
            $this->loadModel("testModel");
            $question_id = $_POST['question_id'];
            $question = $this->testModel->getQuestion($question_id);
            $data['question'] = $question;
            $data['view'] = "tests/question_view";

            $this->view->render($data);
        }

        function preTest($course_hash, $test_hash){
            $this->loadModel("admin");
            $this->loadModel("testModel");
            $test = $this->testModel->getTestByHash($test_hash);
            $course = $this->admin->getCourseHash($course_hash);

            //Check if the date end is okey or not
            if($test->getDateClose() < date("Y-m-d H:i:s")){
                header("Location:".URL."CourseController/courseDashboard/".$course->getHash());
                exit();
            }


            $data['breadcrumbs'] = $this->breadcrumbs .= "<a href='".URL."CourseController/courseDashboard/".$course->getHash()."' title='Course Dashboard'> ".$course->getName()."</a> "." / ". $test->getName() ." /";
            $data['test'] = $test;
            $data['course'] = $course;
            $data['view'] = "tests/pre_test";
            $this->view->view_loader($data);
        }

        function test($course_hash, $test_hash){
            $this->loadModel("admin");
            $this->loadModel("testModel");
            $test = $this->testModel->getTestByHash($test_hash);
            $course = $this->admin->getCourseHash($course_hash);

            $haveScore = $this->testModel->checkUserTest($test->getId(), $_SESSION['user']->getUser_id());

            if($haveScore){
                if(!is_null($haveScore['date_start'])){
                    header("Location:".URL."CourseController/courseDashboard/".$course_hash);
                    exit();
                }
            }
            //save data in db
            $dateStart = date("Y-m-d H:i:s");
            $ip = $this->getIP();
            $this->testModel->userStartTest($test->getId(), $_SESSION['user']->getUser_id(), $dateStart, $ip);

            $data['breadcrumbs'] = "";
            $data['test'] = $test;
            $data['course'] = $course;
            $data['view'] = "tests/test_view";
            $this->view->render($data);
        }


        function cheats(){
            $this->loadModel("testModel");
            $this->loadModel("admin");
            $test = $this->testModel->getTestByHash($_POST['test_hash']);
            $user = $this->admin->getUserByHash($_POST['user_hash']);

            $this->testModel->updateCheats($test->getId(), $user->getUser_id(), $_POST['user_cheat']);
        }

        function openTest(){
            $status = $_POST['status'];
            $test_id = $_POST['test_id'];
            $this->loadModel("testModel");
            $test = $this->testModel->getTestById($test_id);
            $count = 0;
            if($test->getQuestions() != NULL){
                $count =count($test->getQuestions());
            }

            if($count != $test->getTotalQuestions()){
                $msg = array( "status" => "ERROR", "message" =>"Test can't open: ".$test->getName().", because the current settings do not match test settings");
                echo json_encode($msg);
                return false;
            }

            $result = $this->testModel->openTest($test_id, $status);

            if($result){
                $msg = array( "status" => "true", "message" =>"The Test was Opened." );
                echo json_encode($msg);
                return true;
            } else {
                $msg = array( "status" => "ERROR", "message" =>"You got an error.".$result);
                echo json_encode($msg);
                return false;
            }
        }


        function processTest(){
            $this->loadModel("testModel");
            $dateEnd = date("Y-m-d H:i:s");
            $test = $this->testModel->getTestByHash($_POST['test_hash']);
            foreach($test->getQuestions() AS $question){
                switch ($question->getQuestionType()){
                    case "simple":
                        foreach($_POST AS $key => $value){
                            if($question->getId() == $key){
                                $answer = $this->testModel->getAnswer($value);
                                $question->setStudentAnswer($answer);
                            }
                        }
                        break;
                    case "multiple":
                        foreach($_POST AS $key => $value){

                            if($question->getId() == $key){
                                $answers = array();
                                if(is_array($value)){
                                    foreach($value AS $answer_id){
                                        $answer = $this->testModel->getAnswer($answer_id);
                                        array_push($answers, $answer);
                                    }
                                } elseif($value == ""){
                                    $answers = "";
                                }
                                $question->setStudentAnswer($answers);
                            }
                        }
                        break;

                    case "written":
                        foreach($_POST AS $key => $value){
                            if($question->getId() == $key){
                                $question->setStudentAnswer($value);
                            }
                        }
                        break;
                }
            }

            //THIS CODE IS FOR GET THE SCORE
            $trueCount = $test->getTrueCount();
            $wrongDiscount = $test->getWrongDiscount();
            $totalQuestions = $test->getTotalQuestions();
            $getScore = 0;

            foreach($test->getQuestions() AS $question){
                switch ($question->getQuestionType()){
                    case "simple":
                        if(!empty($question->getStudentAnswer())){
                            if($question->getStudentAnswer()->isValue()){
                                $getScore += $trueCount;
                            } else {
                                $getScore -= $wrongDiscount;
                            }
                        }
                        break;
                    case "multiple":
                        //Comprobamos si la respuesta del usuario no es vacia
                        if(!empty($question->getStudentAnswer())){
                            $totalTrue = 0;
                            $userTrue = 0;
                            $userFalse = 0;

                            //Recorremos las respuestas y obtenemos el numero de verdaderas
                            foreach($question->getAnswers() AS $answer){
                                if($answer->isValue()){
                                    $totalTrue++;
                                }
                            }

                            //Si el usuario respondio varias sacamos las respuestas del usuario que son
                            //veradderas y las que son falsas
                            if(is_array($question->getStudentAnswer())){
                                foreach($question->getStudentAnswer() AS $answer){
                                    if($answer->isValue()){
                                        $userTrue++;
                                    } else {
                                        $userFalse++;
                                    }
                                }
                            } else{
                               if($question->getStudentAnswer()->isValue()){
                                   $userTrue++;
                               }
                            }

                            //Si las respuestas del user y las totales son iguales otorgamos punto entero
                            //De lo contrario Restamos a las respuestas veradderas del usuario las falsas y
                            //si las respuestas son 0 o menos restamos al score total lo correspondiente
                            //Si es diferente o mayor a 0 es porque tiene alguna verdadera y sacamos la parte proporcional de su valor
                            if($userTrue == $totalTrue && $userFalse == 0){
                                $getScore += $trueCount;
                            } else {
                                $userTrue -= $userFalse;

                                if($userTrue > 0){
                                    $getScore+= ($userTrue * $trueCount) / $totalTrue;
                                } else {
                                    $getScore -= $wrongDiscount;
                                }
                            }
                        }
                        break;
                    case "written":
                        if(!empty($question->getStudentAnswer()) || $question->getStudentAnswer() != NULL){
                            $trueResult = str_replace(" ", "", $question->getResult()[0]->getText());
                            $trueResult = strtolower($trueResult);
                            $userResult = str_replace(" ", "", $question->getStudentAnswer());
                            $userResult = strtolower($userResult);

                            if($userResult == $trueResult){
                                $getScore += $trueCount;
                            } else {
                                $getScore -= $wrongDiscount;
                            }
                        }
                        break;
                }
            }

            $totalScore = $getScore * BASENOTE / ($trueCount*$totalQuestions);
            $this->testModel->updateUserFinish($test->getId(), $_SESSION['user']->getUser_id(), $totalScore, $dateEnd);

            $test->setUserTest($this->testModel->checkUserTest($test->getId(), $_SESSION['user']->getUser_id()));

            $this->testModel->saveSerializeTest($test->getId(), $_SESSION['user']->getUser_id(), $test);
            $newTest = $this->testModel->getSerializeTest($test->getId(), $_SESSION['user']->getUser_id());

            $data['breadcrumbs'] = $this->breadcrumbs .= " ".$test->getName() ." End /";
            $data['view'] = "tests/post_test";
            $this->view->view_loader($data);

        }

        function viewResult($test_hash, $user_hash, $course_hash) {
            $this->loadModel("testModel");
            $this->loadModel("admin");
            $course = $this->admin->getCourseHash($course_hash);
            $test = $this->testModel->getTestByHash($test_hash);
            $user = $this->admin->getUserByHash($user_hash);
            $resultTest = $this->testModel->getSerializeTest($test->getId(), $user->getUser_id());

            $data['breadcrumbs'] = $this->breadcrumbs .= "<a href='".URL."CourseController/courseDashboard/".$course->getHash()."' title='Course Dashboard'> ".$course->getName()."</a> "." / ". $test->getName() ." Review /";

            $data['user'] = $user;
            $data['test'] = $resultTest;
            if($this->infoAdTe()){
                $data['return'] = URL."CourseController/managerCourse/".$course_hash;
            } else {
                $data['return'] = URL."CourseController/courseDashboard/".$course_hash;
            }
            $data['view'] = "tests/test_review";

            $this->view->view_loader($data);
        }

        function viewTestStatus($test_hash, $course_hash){
            $this->loadModel("testModel");
            $this->loadModel("admin");
            $test = $this->testModel->getTestByHash($test_hash);
            $status = $this->testModel->checkTestStatus($test->getId());
            $course = $this->admin->getCourseHash($course_hash);

            $data['breadcrumbs'] = $this->breadcrumbs .= "<a href='".URL."CourseController/managerCourse/".$course->getHash()."' title='Course Dashboard'> ".$course->getName()."</a> "." / ". $test->getName() ." Review /";
            $data['user_status'] = $status;
            $data['test_hash'] = $test_hash;
            $data['course_hash'] = $course_hash;
            $data['view'] = "tests/table_status";

            $this->view->view_loader($data);
        }


    }

?>