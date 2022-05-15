<?php

    Class Main  extends Controller{

        function __construct(){
            parent::__construct();
            $this->breadcrumbs = "<a href='".URL."main/dashboard'>Dashboard</a> /";
        }

        function index(){ 
          return $this->login();
        }

        function login(){
          return  $this->view->view_loader("login");
        }

        function ajax_login(){
            $this->loadModel('login');
            $email = $_POST['email'];
            $pass = md5($_POST['pass']);
            $userLogin = $this->login->loginUser($email, $pass);

            if($userLogin != NULL){

                $result = array(
                    "ResultCode" => 1,
                    "message" => "Login user",
                    "token" => hash("sha512","token".time())
                );
                setcookie("token", $result['token'], time()+(3600*24), "/");
                $_SESSION['token'] = $result['token'];
                $_SESSION['user'] = $userLogin;
                echo json_encode($result);
                
                return true;

            } else {
                $result = array(
                    "ResultCode" => "ERROR",
                    "message" => "Login Error, User or password wrong!",
                );
                echo json_encode($result);
            }
        }

        function getIP(){
            if (!empty($_SERVER['HTTP_CLIENT_IP']))  
            {  
                $ip=$_SERVER['HTTP_CLIENT_IP'];  
            }  
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
            //to check ip is pass from proxy  
            {  
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
            }  
            else  
            {  
                $ip=$_SERVER['REMOTE_ADDR'];  
            }  
            return $ip;
        }

        function dashboard(){
            $userLogin = $_SESSION['user'];
            $courses = array();
            $fCourses = array();
            if($userLogin->getFirstTime() == "0000-00-00 00:00:00"){
                $this->updateStudent();
                exit();
            }

            $this->loadModel("login");
            $this->loadModel("admin");

            if($this->infoAdmin()){
                $courses = $this->admin->getCourses();
            } else {
                $courses = $this->login->userCourses($userLogin->getUser_id());
            }
            
            $propietary = array();
            if($this->infoAdTe()){
                $propietary = $this->admin->propietaryCourse($userLogin->getUser_id());
            }
            //Create a unique array with all of courses that the user have as a student and as a creator

            

            if(!is_null($courses)){
                if(is_null($propietary) || empty($propietary)){
                    $fCourses = $courses;
                } else {
                    $fCourses = array_merge($propietary, $courses);
                    $fCourses = array_unique($fCourses, SORT_REGULAR);
                }

            } else {
                if(!is_null($propietary) || !empty($propietary)){
                    $fCourses = $propietary;
                } 
            }




            //if user didn't have login redirect.
            if($userLogin != NULL){
                $data['isAdmin'] = $this->infoAdmin();
                $data['users'] = $this->login->getUsers();
                $data['user'] = $userLogin;
                $data['breadcrumbs'] = $this->breadcrumbs;
                $data['view'] = "dashboard";
                $data['courses'] = $fCourses;

                $this->view->view_loader($data);
            } else {
                header("Location:".URL);
                exit();
            } 
        }

        function ajax_updateUser(){
            $this->loadModel('admin');
            $hash = $_POST['hash'];
            $user = $this->admin->getUserByHash($hash);
            $location = $user->getPhoto();
            
            if(isset($_FILES['file']['name'])){

                /* Getting file name and change the name for the user Hash*/
                $filename = $_FILES['file']['name'];
                $extension = explode(".", $filename);
                $hash = $_POST['hash'];
                $extension = end($extension);
                $filename =$hash.".".$extension;

                
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
            $user_ip = $this->getIP(); 
            $first_time = date('Y-m-d h:i:s');
            $hash = $_POST['hash'];
            $status = $this->admin->updateUser($name, $last_name, $passport, $email, $pass, $photo, $user_ip, $first_time, $hash);

            if($status != true){
                $result = array( "status" => "ERROR", "message" => "INSERT ERROR" );
                echo json_encode($result);
                return false;
            } else {
                $result = array( "status" => "success", "message" =>"Insert Ok" );
                echo json_encode($result);
                return true;
            }
        }

        function ajax_sendMsg(){
            $this->loadModel('messageModel');
           

            $user_send = $_SESSION['user']->getUser_id();
            $subject = $_POST['subject'];
            $receptors = $_POST['receptors'];
            $msg = $_POST['message'];
            $date_send = date('Y-m-d h:i:s');

            $status = $this->messageModel->saveMsg($user_send, $subject, $msg, $date_send, $receptors);

            if($status != true){
                $result = array( "status" => "ERROR", "message" => "Error the message could not be sent." );
                echo json_encode($result);
                return false;
            } else {
                $result = array( "status" => "success", "message" =>"Insert Ok" );
                echo json_encode($result);
                return true;
            }
        }

        //return number of msg
        function ajax_updateMsg(){
            $this->loadModel('messageModel');
            $status = $this->messageModel->userGetMsgs($_SESSION['user']->getUser_id());
            echo json_encode($status);
            return;
        }

        function ajax_updateRelation(){
            $this->loadModel('messageModel');

            $relation_id = $_POST['relation_id'];
            $status = $this->messageModel->updateView($relation_id);
            $status = $this->messageModel->getMessageFull($relation_id);

            echo json_encode($status);

            return false;
        }

        function ajax_forgot_pass(){
            $this->loadModel("login");
            $email = $_POST['email'];
            $newPass = $this->login->ajaxForgotPass($email);
            $return = "<p>Copy and use this password for doing login.</p><div class='input-group mb-4'><span class='input-group-text bg-primary'><i class='bi bi-key-fill text-white'></i></span><input type='text' class='form-control' value='$newPass' disabled/></div>";
            if($newPass == NULL){
                return null;
            }

            echo $return;
            return;
        }
        

        function updateStudent($hash = ""){
            $this->loadModel('admin');

            if(!empty($hash)){
                $user = $this->admin->getUserByHash($hash);
                $data['editAdmin'] = true;
            } else {
                $user = $_SESSION['user'];
            }

            $data['breadcrumbs'] = $this->breadcrumbs .= " Update Student /";
            $data['view'] = "update-user";
            $data['type'] = "update";
            $data['title'] = "Update Student";
            $data['user'] = $user;
            $data['userType'] = $this->admin->userTypes();
            
            $this->view->view_loader($data);
        }

        function ajax_newEvent(){
            $this->loadModel("calendarModel");
            $name = $_POST['name'];
            $dateStart = $_POST['dateStart'];
            $dateEnd = $_POST['dateEnd'];
            $color = $_POST['color'];
            $user_id = $_SESSION['user']->getUser_id();
            $all_day = $_POST['allDay'];
            $insertStatus = $this->calendarModel->saveEvent($name, $color, $dateStart, $dateEnd, $all_day, $user_id);
            if($insertStatus){
                echo $insertStatus;
            } else {
                echo null;
            }
        }

        function ajax_loadEvents(){
            try{
                $this->loadModel("calendarModel");

                $user_id = $_SESSION['user']->getUser_id();
                $insertStatus = $this->calendarModel->getUserEvents($user_id);
                
                if($insertStatus){
                    echo json_encode($insertStatus);
                } else {
                    echo null;
                }
            }catch(Exception $e){
                echo "Error ocurred.";
            }
        }

        function ajax_delet_event(){
            try{
                $id = $_POST['id'];
                $this->loadModel("calendarModel");
                $status = $this->calendarModel->delEvent($id);
                if($status){
                    echo true;
                    return;
                } else {
                    echo false;
                    return;
                }
            }catch(Exception $e){
                echo "Error ocurred.";
            }
        }
        
        function ajax_update(){
            $this->loadModel("calendarModel");
            $name = $_POST['name'];
            $dateStart = $_POST['dateStart'];
            $dateEnd = $_POST['dateEnd'];
            $color = $_POST['color'];
            $all_day = $_POST['allDay'];
            $id = $_POST['id'];

            $insertStatus = $this->calendarModel->setEvent($id, $name, $color, $dateStart, $dateEnd, $all_day);
            if($insertStatus){
                echo $insertStatus;
            } else {
                echo null;
            }
        }

        function logout() {
            session_unset();
            session_destroy();
            setcookie("token", "", time()-1, "/");
            header("Location:".URL);
            exit();
        }

    }

?>