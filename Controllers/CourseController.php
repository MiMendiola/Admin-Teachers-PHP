<?php
Class CourseController extends Controller{

    function __construct(){
        parent::__construct();
        $this->breadcrumbs = "<a href='".URL."main/dashboard'>Dashboard</a> /";
    }  

    function index(){ 
        header("Location:".URL);
        exit();
    }

    function courseDashboard($hash){
        $this->loadModel("admin");
        $this->loadModel("courseModel");
        $course = $this->admin->getCourseHash($hash);
        if($course->getOpen() == 0 && !$this->infoAdmin() && $course->getUser_create()->getUser_id() != $_SESSION['user']->getUser_id()){
            header("Location:".URL);
        }

        //if the folder doesn't exist we redirect to user at error 404
        if(!file_exists($course->getFolder())){
            $this->error(404);
            exit();
        }

        $files = scandir($course->getFolder());
        $realFiles = array();
        $dots = array("..", ".");
        $forums = $this->courseModel->getFormusByCourse($course->getCourse_id());
        foreach($files as $file){
            if(!in_array($file, $dots)){
                $realFiles[] = $file;
            }
        }
        $data['forums'] = $forums;
        $data['files'] = $realFiles;
        $data['extValid'] = array("jpg", "png", "jpeg", "webp", "pdf", "mp3", "mp4");
        $data['course'] = $course;
        $data['breadcrumbs'] = $this->breadcrumbs.=  " ". $course->getName()." /";
        $data['view'] = "course_view";
        $this->view->view_loader($data);
    }

    function managerCourse($hash){
        $this->isAdTe();
        $this->loadModel("admin");
        $course = $this->admin->getCourseHash($hash);

        if($_SESSION['user']->getUser_type_id() == 3 && $_SESSION['user']->getUser_id() != $course->getUser_create()->getUser_id()){
            header("Location:".URL."/views/errors/401.php");
            exit();
        }

        //if the folder doesn't exist we redirect to user at error 404
        if(!file_exists($course->getFolder())){
            $this->error(404);
            exit();
        }
        $files = scandir($course->getFolder());
        $realFiles = array();
        $dots = array("..", ".");
        foreach($files as $file){
            if(!in_array($file, $dots)){
                $realFiles[] = $file;
            }
        }
        $data['files'] = $realFiles;
        $data['extValid'] = array("jpg", "png", "jpeg", "webp", "pdf", "mp3", "mp4");
        $data['course'] = $course;
        $data['users'] = $this->admin->getUsers();
        $data['breadcrumbs'] = $this->breadcrumbs.= "<a href='".URL."adminController/coursesManager'> Courses Manager </a> /" .$course->getName()." /";
        $data['view'] = "course_management";
        $data['random'] = $this->admin->randomPassword();
        $data['loginZoom'] = "";


        $this->view->view_loader($data);
    }

    function ajax_delete(){
        if(unlink($_POST['path'])) {
            // file was successfully deleted
        echo json_encode( array("status" =>"true", "message"=> "The file was deleted"));
        } else {
        // there was a problem deleting the file
        echo json_encode( array("status" =>"ERROR", "message"=> "Error ocurred, the fild couldn't be deleted."));
        }
    }

    function ajax_unsuscribe_user(){
        $this->loadModel("admin");

        $user_id = $_POST['user_id'];
        $course_id = $_POST['course_id'];

        $status = $this->admin->unsuscribeUserCourse($user_id, $course_id);

        echo $status;
    }

    function ajax_openClose_Course(){
        $this->loadModel("admin");
        $status = $_POST['status'];
        $course_id = $_POST['course_id'];
        $result = $this->admin->openCourse($status, $course_id);

        switch($status){
            case 0:
                if($result){
                    echo json_encode( array("status" =>"true", "message"=> "The Course is Closed!"));
                } else {
                    echo json_encode( array("status" =>"ERROR", "message"=> "Error ocurred: ". $status));
                }
                break;
                case 1:
                    if($result){
                        echo json_encode( array("status" =>"true", "message"=> "The Course is open!"));
                    }else {
                        echo json_encode( array("status" =>"ERROR", "message"=> "Error ocurred: ". $status));
                    }
                break;
        }
        return false;
    }

    function openCourse(){
        $this->loadModel("admin");

        $course_id = $_POST['course_id'];
        $this->admin->openCourse($course_id);
        
    }

    function ajaxUploadFile(){

        $this->loadModel('admin');
        $location = "";
        if(isset($_FILES['file']['name'] )){

            /* Getting file name and change the name for the user Hash*/
            $filename = $_FILES['file']['name'];

            /* Location */
            $location = $_POST['path']."/".$filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
                  
            $response = 0;
            /* Upload file */
            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                $response = $location;
            }
                            
            if($response === 0){
                $result = array( "status" => "ERROR", "message" => "The file don't has been uploaded." );
                echo json_encode($result);
                return false;
            }

            $result = array( "status" => "true", "message" => "The file has been uploaded." );
            echo json_encode($result);
            return false;
        }
    }

    function ajax_write(){
        $this->loadModel("courseModel");
        $msg = $_POST['msg'];
        $user_id = $_SESSION['user']->getUser_id();
        $course_id = $_POST['course_id'];
        $date = date("Y-m-d H:i:s");
        if(isset($_POST['replay'])){
            $replay = $_POST['replay'];
           $returned = $this->courseModel->insertPost($user_id, $msg, $course_id, $date, $replay);
        } else {
            $returned =  $this->courseModel->insertPost($user_id, $msg, $course_id, $date);
        }

        $forum = $this->courseModel->getFormusByCourse($course_id);

        if($returned){
            $print = $this->printForm($forum);
            echo $print;
        } else {
            $result = array( "status" => "ERROR", "message" => "A error ocurred when you tried create post: "+$returned );
            echo json_encode($result);
        }
    }

    function printForm($forums){
        $data['view'] = "forum/forum_view";
        $data['forums'] = $forums;
        $this->view->render($data);
    }

    function ajax_PrintHTML(){
        $path = $_POST['path'];
        $file = $_POST['file'];
        $ext = explode(".", $file);
        $ext = end($ext);
        switch($ext){
            case "jpg":
                echo "<img width='100%' src='".URL.$path."'>";
                break;
            case "png":
                echo "<img width='100%' src='".URL.$path."'>";
                break;
            case "jpeg":
                echo "<img width='100%' src='".URL.$path."'>";
                break;
            case "webp":
                    echo "<img width='100%' src='".URL.$path."'>";
                break;
            case "pdf":
                echo "<embed src='".URL.$path."' type='application/pdf' width='100%' height='600px' />";
                break;
            case "mp3":
                echo "<div class='text-center'><audio class='file' controls><source src='".URL.$path."' type='audio/ogg'><source src='".URL.$path."' type='audio/mpeg'> Your browser does not support the audio element. </audio></div>";
                break;
            case "docx":
                echo "<embed src='".URL.$path."' type='application/pdf' width='100%' height='600px' />";
                break;
            case "mp4":
                    echo "<div class='text-center'><video class='file' controls autoplay width='640' height='480'> <source src='".URL.$path."' type='video/mp4'></video></div>";
                break;
        }
    }        
   
}
?>