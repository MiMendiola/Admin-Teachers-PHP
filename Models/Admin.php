<?php
    Class Admin extends Model{
        function __construct(){
            parent::__construct();
        }

        function newUser($name, $last_name, $passport, $email, $pass, $hash, $photo, $typeUser){
            if(!$this->noDupliUser($email)){
                return "User with email: $email exist.";
            }

            try{
                $query = $this->db->connect()->prepare("INSERT INTO users (name, last_name, passport, email, pass, hash, photo, user_type_id) VALUES(:name, :last_name, :passport, :email, :pass, :hash, :photo, :typeUser)");
                if($query->execute(array(':name'=>$name, ':last_name'=>$last_name, ':passport'=>$passport, ':email'=>$email, ':pass'=>$pass, ':hash'=>$hash, ':photo'=> $photo, ':typeUser'=>$typeUser)) == true){
                    
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
        
        function getUserByHash($hash){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users WHERE hash = :hash");
                $query->execute(array(':hash'=> $hash));
                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $user = new User($row['user_id'], $row['name'],$row['last_name'],$row['passport'],$row['email'],$row['pass'],$row['normal_ip'],$row['hash'],$row['photo'],$row['user_type_id'], $row['first_time']);
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

        function getUser($email, $pass){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users WHERE email = :email AND pass = :pass");
                $query->execute(array(':email'=> $email, ':pass' => $pass));
                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $user = new User($row['user_id'], $row['name'],$row['last_name'],$row['passport'],$row['email'],$row['pass'],$row['normal_ip'],$row['hash'],$row['photo'],$row['user_type_id'], $row['first_time']);
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

        function noDupliUser($email){
            try {
                $query = $this->db->connect()->prepare("SELECT email FROM users WHERE email = :email");
                $query->execute(array(':email'=> $email));
                if($query->rowCount() > 0){
                    return false;

                } else {
                    return true;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function noDupliCourses($courseName){
            try {
                $query = $this->db->connect()->prepare("SELECT course_name FROM courses WHERE course_name = :course");
                $query->execute(array(':course'=> $courseName));
                if($query->rowCount() > 0){
                    return false;
                } else {
                    return true;
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

        function getUsersPass(){
            try {
                $query = $this->db->connect()->prepare("SELECT passport FROM users");
                $query->execute();
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        
                        $returnQuery[]= $row['passport'];
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

        function getUsersEmail(){
            try {
                $query = $this->db->connect()->prepare("SELECT email FROM users");
                $query->execute();
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        
                        $returnQuery[]= $row['email'];
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

        function userTypes(){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM user_types");
                $query->execute();
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $returnQuery[$row['type_id']] = $row['type_name'];
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

        function updateUser($name, $last_name, $passport, $email, $pass, $photo, $user_ip, $first_time, $hash){
            try {
                $query = $this->db->connect()->prepare("UPDATE users SET name = '".$name."', last_name = '".$last_name."', passport ='".$passport."', email = '".$email."', pass = '".$pass."', normal_ip = '".$user_ip."', photo = '".$photo."', first_time = '".$first_time."' WHERE hash ='".$hash."';");
                if($query->execute()){
                    $user = $this->getUserByHash($_SESSION['user']->getHash());
                    $_SESSION['user'] = $user;
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

        function deleteUser($user_id){
            try {
                if($_SESSION['user']->getUser_id() == $user_id){
                    return false;
                }
                $query = $this->db->connect()->prepare("DELETE FROM users WHERE user_id = :user_id;");

                if($query->execute(array(":user_id"=>$user_id))){
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

        function unsuscribeUserCourse($user_id, $course_id){
            try {                
                $query = $this->db->connect()->prepare("DELETE FROM user_course WHERE user_id = :user_id AND course_id = :course_id ;");
                
                if($query->execute(array(":user_id"=>$user_id, "course_id"=>$course_id))){
                    return true;
                } else {
                    return false;
                }

            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function propietaryCourse($user_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM courses WHERE user_create = '".$user_id."';");
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

        function openCourse($status, $course_id){
            try {
                $query = $this->db->connect()->prepare("UPDATE courses SET open = '".$status."'  WHERE course_id ='".$course_id."';");
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

        function updateCourse($course_id, $photo, $course_name, $course_description, $students){
            try {
                $query = $this->db->connect()->prepare("UPDATE courses SET course_name = '".$course_name."', course_description='".$course_description."', course_img='".$photo."'  WHERE course_id ='".$course_id."';");
                if($query->execute()){
                    $studentsCourse = $this->coursesUser($course_id);
                    //we create a new array only with the ids
                    $sid = array();
                    foreach($studentsCourse AS $studentCourse){
                        array_push($sid, $studentCourse->getUser_id());
                    }

                    if(!empty($students)){
                        if(is_array($students)){
                            foreach($students as $student){
                                if(!in_array($student, $sid)){
                                    $this->insertRelationUserCourse($student, $course_id);
                                }
                            }
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

        function insertCourse($hash, $course_img, $course_name, $course_description, $course_folder, $user_create, $date_create, $students){
 
            if(!$this->noDupliCourses($course_name)){
                $result = array( "status" => "ERROR", "message" => "The course with the name $course_name exist on the DB." );
                echo json_encode($result);
                return false;
            }

            try{
                $query = $this->db->connect()->prepare("INSERT INTO courses (course_name, course_description, course_folder, hash, course_img, user_create, date_create) VALUES(:course_name, :course_description, :course_folder, :hash, :course_img, :user_create, :date_create)");
                if($query->execute(array(":course_img"=>$course_img, ":course_name" => $course_name,"course_description" => $course_description, ":hash"=> $hash, ":course_folder" =>$course_folder, ":user_create"=> $user_create, ":date_create"=>$date_create)) == true){
                    //Create Course directory
                     if(!mkdir($course_folder, 0777)){
                        return "ERROR, Failed to create course directory";
                    }

                    //Create asociation students with course
                    $course = $this->getCourseName($course_name);
                    $this->insertRelationUserCourse($user_create, $course->getCourse_id());

                    //Check type of students variable to insert
                    if(!empty($students)){
                        if(!is_array($students)){
                            $this->insertRelationUserCourse($students, $course->getCourse_id());
                        } else {
                            foreach($students as $user_id){
                        $this->insertRelationUserCourse($user_id, $course->getCourse_id());
                            }
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

        function insertRelationUserCourse($user_id, $course_id){
            $query = $this->db->connect()->prepare("INSERT INTO user_course (user_id, course_id) VALUES(:user, :course)");
            if($query->execute(array(":user"=>$user_id, ":course"=>$course_id))){
                return true;
            } else {
                return false;
            }
        }
        
        function getCourses(){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM courses");
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

        function getCourseName($name){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM courses WHERE course_name = :name");
                $query->execute(array(":name"=>$name));
                if($query->rowCount() == 1){
                    
                    while($row = $query->fetch()){
                        $test = "test_id";//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        $students = $this->coursesUser($row['course_id']);
                        $creator = $this->getUserById( $row['user_create']);

                        $course = new Course($row['course_id'], $row['course_name'], $row['course_description'], $row['course_folder'], $creator, $test, $row['course_img'], $row['date_create'], $students, $row['open'], $row['hash']);
                    }
                    return $course;
                } else {
                    return NULL;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getCourseId($course_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM courses WHERE course_id = :course_id");
                $query->execute(array(":course_id"=>$course_id));
                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $test = "";//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        $students = $this->coursesUser($row['course_id']);
                        $creator = $this->getUserById($row['user_create']);
                        $course = new Course($row['course_id'], $row['course_name'], $row['course_description'], $row['course_folder'], $creator, $test, $row['course_img'], $row['date_create'], $students, $row['open'], $row['hash']);
                    }

                    return $course;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getCourseHash($hash){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM courses WHERE hash = :hash");
                $query->execute(array(":hash"=>$hash));
                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $test = "";//----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                        $students = $this->coursesUser($row['course_id']);
                        $creator = $this->getUserById($row['user_create']);
                        $course = new Course($row['course_id'], $row['course_name'], $row['course_description'], $row['course_folder'], $creator, $test, $row['course_img'], $row['date_create'], $students, $row['open'], $row['hash']);
                    }

                    return $course;
                } else {
                    return NULL;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

    }
?>