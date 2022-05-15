<?php
    Class TestModel extends Model{
        function __construct(){
            parent::__construct();
        }

        function saveTest($name, $description, $questions, $date_open, $time, $courses){
            try {
                $query = $this->db->connect()->prepare("INSERT INTO tests (test_id, name, description, questions, date_open, time) VALUES(:name, :description, :questions, :date_open, :time)");
                if($query->execute(array(":name"=>$name, ":description"=>$description, ":questions"=> $questions, ":date_open"=>$date_open, ":time"=>$time))){
                    $test = $this->getNowTest($name, $date_open, $time);

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

        function getNowTest($name, $date_open, $time){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM tests WHERE name ='".$name."' AND date_open= '".$date_open."' AND time='".$time."';");
                $query->execute();

                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                            $test = new Test($row['test_id'], $row['name'], $row['description'], $row['questions'], $row['date_open'], $row['time']);
                    }

                    return $test;
                } else {
                    return NULL;
                }

                $query->close();
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function saveRelationCoursesTest($id_test, $id_course){
            $query = $this->db->connect()->prepare("INSERT INTO course_test (test_id, course_id) VALUES(:id_test, :course)");
            if($query->execute(array(":test"=>$id_test, ":course"=>$id_course))){
                return true;
            } else {
                return false;
            }
        }


    }
?>