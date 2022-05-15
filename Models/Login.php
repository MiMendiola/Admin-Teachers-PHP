<?php
    Class Login extends Model{
        function __construct(){
            parent::__construct();
        }

        function loginUser($email, $pass){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users WHERE email = :email AND pass = :pass");
                $query->execute(array(':email'=> $email, ':pass' => $pass));
                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        
                        $user = new User($row['user_id'], $row['name'],$row['last_name'],$row['passport'],$row['email'],$row['pass'],$row['normal_ip'],$row['hash'],$row['photo'],$row['user_type_id'], $row['first_time']);
                        //Update the last access
                        $this->updateLastAccess($row['user_id']);
                    }
                    return $user;
                } else {
                    return NULL;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function updateLastAccess($id){
            try {
                $query = $this->db->connect()->prepare("UPDATE users SET first_time = '".date('Y-m-d h:i:s')."' WHERE user_id ='".$id."';");
                if($query->execute()){
                    return true;
                } else {
                    return false;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function coursesUser($courseId){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM user_course JOIN users ON user_course.user_id = users.user_id WHERE user_course.course_id = '".$courseId."';");
                $query->execute();
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $user = new User($row['user_id'], $row['name'],$row['last_name'],$row['passport'],$row['email'],$row['pass'],$row['normal_ip'],$row['hash'],$row['photo'],$row['user_type_id'], $row['first_time']);
                        $returnQuery[]= $user;
                    }

                    return $returnQuery;
                } else {
                    return NULL;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function userCourses($userId){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM user_course JOIN courses ON user_course.course_id = courses.course_id WHERE user_course.user_id = '".$userId."';");
                $query->execute();
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $test = "test_id";//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        $students = $this->coursesUser($row['course_id']);
                        $creator = $this->getUserById( $row['user_create']);

                        $course = new Course($row['course_id'], $row['course_name'], $row['course_description'], $row['course_folder'], $creator, $test, $row['course_img'], $row['date_create'], $students, $row['open'], $row['hash']);
                    $returnQuery[]= $course;
                    }
                    return $returnQuery;
                } else {
                    return NULL;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getUsers(){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users");
                $query->execute();
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $user = new User($row['user_id'], $row['name'],$row['last_name'],$row['passport'],$row['email'],$row['pass'],$row['normal_ip'],$row['hash'],$row['photo'],$row['user_type_id'], $row['first_time']);
                        $returnQuery[]= $user;
                    }

                    return $returnQuery;
                } else {
                    return NULL;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function ajaxForgotPass($email){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users WHERE email = :email");
                $query->execute(array(':email'=> $email));
                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $newPass = $this->randomPassword();
                        $this->setPass($row['user_id'], $newPass);
                    }

                    return $newPass;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }
        function setPass($id, $newPass){
            $passCodify = md5($newPass);
            try {
                $query = $this->db->connect()->prepare("UPDATE users SET first_time = '0', pass = '".$passCodify."' WHERE user_id = '".$id."';");
                if($query->execute()){
                    return true;
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