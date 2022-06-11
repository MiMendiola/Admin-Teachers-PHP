<?php
Class CourseModel extends Model{
    function __construct(){
        parent::__construct();
    }

    
    function insertPost($user_id, $msg, $course_id, $date, $replay = 0){
         try{
            $query = $this->db->connect()->prepare("INSERT INTO forum (user_id, msg, replay, course_id, date) VALUES(:user_id, :msg, :replay, :course_id, :date)");
            if($query->execute(array(":user_id"=>$user_id, ":msg"=>$msg, ":replay"=>$replay, ":course_id"=>$course_id, ":date"=>$date))){
                return true;
            } else {
                return NULL;
            }
        } catch(PDOException $e){
            echo $e->getMessage();
            return NULL;
        }
    }

    function getForum($id){
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM forum WHERE id='".$id."' ORDER BY date");
            $query->execute();

            if($query->rowCount() == 1){
                while($row = $query->fetch()){
                    $user = $this->getUserById($row['user_id']);
                    $forum = new Forum($row['id'], $user, $row['msg'], $row['course_id'], $row['date'], $row['replay']);
                }

                return $forum;
            } else {
                return NULL;
            }

            $query->close();
        } catch(PDOException $e){
            echo $e->getMessage();
            return NULL;
        }
    }

    function getFormusByCourse($course_id){
        try {
            $query = $this->db->connect()->prepare("SELECT * FROM forum WHERE course_id='".$course_id."' ORDER BY date DESC");
            $query->execute();
            $returnQuery = array();

            if($query->rowCount() > 0){
                while($row = $query->fetch()){
                    if($row['replay'] == 0) {
                        $user = $this->getUserById($row['user_id']);
                        $replys = $this->getReplays($row['id']);
                        $forum = new Forum($row['id'], $user, $row['msg'], $row['course_id'], $row['date'], $replys);
    
                        array_push($returnQuery, $forum);
                    }

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

    function getLastInsert(){
      try {
            $query = $this->db->connect()->prepare("SELECT MAX(id), user_id, msg, replay, course_id, date FROM forum");
            $query->execute();
            if($query->rowCount() == 1 ){
                while($row = $query->fetch()){
                    $user = $this->getUserById($row['user_id']);
                    if($row['replay'] != 0){
                        $replys = $this->getReplays($row['id']);
                        $forum = new Forum($row['id'], $user, $row['msg'], $row['course_id'], $row['date'], $replys);
                    } else {
                        $forum = new Forum($row['id'], $user, $row['msg'], $row['course_id'], $row['date'], $row['replay']);
                    }
                }
                return $forum;
            } else {
                return NULL;
            }
       } catch(PDOException $e){
            echo $e->getMessage();
            return NULL;
        }
    }

    function getReplays($id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM forum WHERE replay='".$id."' ORDER BY date;");
                $query->execute();
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $user = $this->getUserById($row['user_id']);
                        $forum = new Forum($row['id'], $user, $row['msg'], $row['course_id'], $row['date'], $row['replay']);
                        array_push($returnQuery, $forum);
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


}

?>