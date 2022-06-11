<?php

    Class AdminController  extends Controller{

        function __construct(){
            parent::__construct();
            $this->breadcrumbs = "<a href='".URL."main/dashboard'>Dashboard</a> /";
        }

        function index(){ 
            header("Location:".URL);
            exit();
        }

        function showUsers(){ 
            $this->loadModel('admin');
            $this->isAdTe();

            $users= $this->admin->getUsers();
            $userTypes = $this->admin->userTypes();
            
            //get user type and insert the name on the user
            foreach($users as $user){
                foreach($userTypes AS $key => $name){
                    if($user->getUser_type_id() == $key){
                        $user->setUser_type_id(ucfirst($name));
                    }
                }
            }

            $data['breadcrumbs'] = $this->breadcrumbs .= " Show Students /";
            $data['view'] = "show_students";
            $data['users'] = $users;
            
            $this->view->view_loader($data);
        }

        function createStudent(){
            $this->loadModel('admin');
            $this->isAdTe();

            $data['breadcrumbs'] = $this->breadcrumbs .= " Create New Student /";
            $data['view'] = "update-user";
            $data['type'] = "create";
            $data['title'] = "Create New Student";
            $data['userType'] = $this->admin->userTypes();
            $data['random'] = $this->admin->randomPassword();
            
            $this->view->view_loader($data);
        }

        function updateUser(){
            $data['breadcrumbs'] = $this->breadcrumbs .= " Create New Student /";
            $data['view'] = "update-user";
            $data['type'] = "update";
            $data['title'] = "Create New Student";
            $this->view->view_loader($data);
        }

        function ajax_newUser(){
            $this->loadModel("admin");
            $passtports = $this->admin->getUsersPass();
            $emails = $this->admin->getUsersEmail();

            if(!$this->infoAdTe()){
                $result = array( "status" => "ERROR", "message" => "MISSING PERMISIONS" );
                echo json_encode($result);
                return false;
            }

            if(in_array($_POST['passport'], $passtports)){
                $result = array( "status" => "ERROR", "message" => "The DNI exist on the database" );
                echo json_encode($result);
                return false;
            }

            if(in_array($_POST['email'], $emails)){
                $result = array( "status" => "ERROR", "message" => "The email exist on the Database" );
                echo json_encode($result);
                return false;
            }

            $location = "./assets/img/default.png"; 
            $hash = md5(time());

            if(isset($_FILES['file']['name'])){

                /* Getting file name and change the name for the user Hash*/
                $filename = $_FILES['file']['name'];
                $extension = explode(".", $filename);
                $filename =$hash.".".end($extension);

                /* Location */
                $location = "./assets/img/usersImg/".$filename;
                $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
                $imageFileType = strtolower($imageFileType);
             
                /* Valid extensions */
                $valid_extensions = array("jpg","jpeg","png");
             
                $response = 0;
                /* Check file extension */
                if(in_array(strtolower($imageFileType), $valid_extensions)) {
                   /* Upload file */
                   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                      $response = $location;
                   }
                }
                                
                if($response === 0){
                    $result = array( "status" => "ERROR", "message" => "the file is not an image." );
                    echo json_encode($result);
                    return false;
                }
             }

            $photo = $location;
            $name = $_POST['name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $pass = md5($_POST['pass']);
            $passport = $_POST['passport'];
            $typeUser = $_POST['typeUser'];
            $status = $this->admin->newUser($name, $last_name, $passport, $email, $pass, $hash, $photo, $typeUser);
            if($status !== true){
                $result = array( "status" => "ERROR", "message" => "INSERT ERROR $status" );
                echo json_encode($result);
                return false;
            } else {
                $result = array( "status" => "success", "message" =>"Insert Ok" );
                echo json_encode($result);
                return true;
            }
        }

        function ajax_deleteUser(){
            $this->loadModel("admin");
            
            if(!$this->infoAdTe()){
                $result = array( "status" => "ERROR", "message" => "MISSING PERMISIONS" );
                echo json_encode($result);
                return false;
            }

            $user_id = $_POST['user_id'];
            if($_SESSION['user']->getUser_id() == $user_id){
                $result = array( "status" => "ERROR", "message" => "You can't delete yourself" );
                echo json_encode($result);
                return false;
            }

            $userD = $this->admin->getUserById($user_id);
            $status = $this->admin->deleteUser($user_id);

            if($status != true){
                $result = array( "status" => "ERROR", "message" => "Delete ERROR" );
                echo json_encode($result);
                return false;
            } else {
                //clean if picture
                if (file_exists($userD->getPhoto())) {
                    if(strpos($userD->getPhoto(), "default.png") === false){
                        unlink($userD->getPhoto());
                    }
                }

                $result = array( "status" => "success", "message" =>"Delete Ok" );
                echo json_encode($result);
                return true;
            }
        }
        function ajax_openAccount(){
            $user_id = $_POST['user_id'];
            $this->loadModel("admin");
            $user = $this->admin->getUserById($user_id);
            if($user->openAcount()){
                $this->admin->updateStatusAccount($user_id, 0);
            } else {
                $this->admin->updateStatusAccount($user_id, 1);
            }
            $result = array( "status" => "true", "message" => "User account changed" );
            echo json_encode($result);
        }
        function coursesManager(){
            $this->loadModel("admin");
            $this->isAdTe();

            $data['view'] = "course_manager";
            $data['breadcrumbs'] = $this->breadcrumbs .= " Courses Manager";
            $data['users'] = $this->admin->getUsers();
            
            $this->view->view_loader($data);
        }

        function ajax_createCourse(){
            if($this->infoAdTe()){

                $location = "";    
                if(isset($_FILES['file']['name'])){
    
                    /* Getting file name and change the name for the user Hash*/
                    $filename = $_FILES['file']['name'];

                    /* Location */
                    $location = "./assets/img/coursesImg/".$filename;
                    $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
                    $imageFileType = strtolower($imageFileType);
                 
                    /* Valid extensions */
                    $valid_extensions = array("jpg","jpeg","png");
                 
                    $response = 0;
                    /* Check file extension */
                    if(in_array(strtolower($imageFileType), $valid_extensions)) {
                       /* Upload file */
                       if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                          $response = $location;
                       }
                    }
                                    
                    if($response === 0){
                        $result = array( "status" => "ERROR", "message" => "the file is not an image." );
                        echo json_encode($result);
                        return false;
                    }
                 }

                 
                $this->loadModel('admin');
                $photo =$location;
                $course_name = $_POST['course_name'];
                $course_description = $_POST['course_description'];
                $students = "";
                $hash = md5(time());


                if(isset($_POST['students']) && strpos($_POST['students'], ",") == true){
                    $students = explode(",", $_POST['students']);
                    
                } else {
                    $students = $_POST['students'];
                }

                $folder = $hash;
    
                $course_folder = "./CoursesFolder/".$folder;
                $user_create = $_SESSION['user']->getUser_id();
                $date_create = date('Y-m-d h:i:s');
                
                if(empty($photo)){
                    $photo = "assets/img/coursesImg/default.png";
                }
                
                $status = $this->admin->insertCourse($hash, $photo, $course_name, $course_description, $course_folder, $user_create, $date_create, $students);

                if($status !== true){
                    $result = $status;
                    echo $result;
                    return false;
                } else {
                    $result = array( "status" => "success", "message" =>"Insert Ok" );
                    echo json_encode($result);
                    return true;
                }
            } else {
                $result = array( "status" => "ERROR", "message" => "MISSING PERMISIONS" );
                echo json_encode($result);
                return false;
            }
        }

        function ajax_updateCourse(){
            if($this->infoAdmin() || $this->infoTeacher()){
                $location = "";    
                if(isset($_FILES['file']['name'])){
    
                    /* Getting file name and change the name for the user Hash*/
                    $filename = $_FILES['file']['name'];

                    /* Location */
                    $location = "./assets/img/coursesImg/".$filename;
                    $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
                    $imageFileType = strtolower($imageFileType);
                 
                    /* Valid extensions */
                    $valid_extensions = array("jpg","jpeg","png");
                 
                    $response = 0;
                    /* Check file extension */
                    if(in_array(strtolower($imageFileType), $valid_extensions)) {
                       /* Upload file */
                       if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                          $response = $location;
                       }
                    }
                                    
                    if($response === 0){
                        $result = array( "status" => "ERROR", "message" => "the file is not an image." );
                        echo json_encode($result);
                        return false;
                    }
                 }
                 
                $this->loadModel('admin');
                $course_id = $_POST['course_id'];
                $photo =$location;
                $course_name = $_POST['course_name'];
                $course_description = $_POST['course_description'];
                $students = array();
                $course = $this->admin->getCourseId($course_id);

                if(isset($_POST['students']) && strpos($_POST['students'], ",") == true){
                    $students = explode(",", $_POST['students']);
                } else {
                    array_push($students, $_POST['students']);
                }   
                
                if(empty($photo)){
                    $photo = $course->getImg();
                }

                $status = $this->admin->updateCourse($course_id, $photo, $course_name, $course_description, $students);
                if($status !== true){
                    $result = $status;
                    echo $result;
                    return false;
                } else {
                    $result = array( "status" => "success", "message" =>"Insert Ok" );
                    echo json_encode($result);
                    return true;
                }
            } else {
                $result = array( "status" => "ERROR", "message" => "MISSING PERMISIONS" );
                echo json_encode($result);
                return false;
            }
        }

        function userView($userHash){
            if(!$this->infoAdTe()){
                $result = array( "status" => "ERROR", "message" => "MISSING PERMISIONS" );
                echo json_encode($result);
                return false;
            }
            $this->loadModel("admin");
            $userView = $this->admin->getUserByHash($userHash);
            $realUser = $_SESSION['user'];
            $_SESSION['user_view'] =$realUser;
            unset($_SESSION['user']);
            $_SESSION['user']=$userView;
            header("Location:".URL);
        }

        function comeBack(){
            $_SESSION['user'] = $_SESSION['user_view'];
            unset($_SESSION['user_view']);
            header("Location:".URL."adminController/showUsers");

        }

        function ajax_newPass(){
            $this->loadModel("admin");
            echo $this->admin->randomPassword();
        }

        //MIGUEL ---------------------------------------------------------------------------

        function ajax_teacherCreate(){
            $this->loadModel("admin");
            $code = $this->admin->randomPassword();
            $resultQuery = $this->admin->generateTeacherCode($code);
            if($resultQuery === false){
                $result = array( "status" => "ERROR", "message" => "You got an error to generate new Teacher Code" );
                echo json_encode($result);
                return false;
            } else {
                $result = array( "status" => "200", "message" => $resultQuery);
                echo json_encode($result);
                return true;
            }

        }

        function ajax_newTeacher(){
            $this->loadModel("admin");
            $passtports = $this->admin->getUsersPass();
            $emails = $this->admin->getUsersEmail();
            $code = $_POST['code'];
            $codeStatus = $this->admin->getValidCode($code);
            if($codeStatus !== true){
                $result = array( "status" => "ERROR", "message" => $codeStatus );
                echo json_encode($result);
                return false;
            }

            if(in_array($_POST['passport'], $passtports)){
                $result = array( "status" => "ERROR", "message" => "The DNI exist on the database" );
                echo json_encode($result);
                return false;
            }

            if(in_array($_POST['email'], $emails)){
                $result = array( "status" => "ERROR", "message" => "The email exist on the Database" );
                echo json_encode($result);
                return false;
            }

            $location = "./assets/img/default.png";
            $hash = md5(time());

            $photo = $location;
            $name = $_POST['name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $pass = md5($_POST['pass']);
            $passport = $_POST['passport'];
            $typeUser = $_POST['typeUser'];
            $status = $this->admin->newUser($name, $last_name, $passport, $email, $pass, $hash, $photo, $typeUser, date("Y-m-d H:i:s"));
            if($status !== true){
                $result = array( "status" => "ERROR", "message" => "INSERT ERROR $status" );
                echo json_encode($result);
                return false;
            } else {
                $this->admin->setUsedCode($code);
                $result = array( "status" => "success", "message" =>"Insert Ok" );
                echo json_encode($result);
                return true;
            }
        }
    }

?>