<?php
    Class CalendarModel extends Model{
        function __construct(){
            parent::__construct();
        }

        function saveEvent($title, $color, $start_event, $end_event, $all_day, $user_id){
            try{
                $query = $this->db->connect()->prepare("INSERT INTO events (title, color, start_event, end_event, all_day, user_id) VALUES(:title, :color, :start_event, :end_event, :all_day, :user_id)");
                if($query->execute(array(":title"=>$title, ":color"=> $color, ":start_event"=>$start_event, ":end_event"=>$end_event, ":all_day"=> $all_day, ":user_id"=>$user_id)) == true){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getUserEvents($user_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM events WHERE user_id = :id");
                $query->execute(array(":id"=>$user_id));

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        if($row['all_day'] == 0 ){
                            $allDay = false;
                        } else {
                            $allDay = true;
                        }
                        $returnQuery[] = ["id"=>$row['id'], "title" => $row['title'],"color"=>$row['color'], "start"=>$row['start_event'], "end"=>$row['end_event'], "allDay"=>$allDay] ;
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

        function delEvent($id){
            try {
                $query = $this->db->connect()->prepare("DELETE FROM events WHERE id = :id");
                if($query->execute(array(":id"=>$id))){
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

        function setEvent($id, $title, $color, $start_event, $end_event, $all_day){
            try {
                $query = $this->db->connect()->prepare("UPDATE events SET title='".$title."', color='".$color."', start_event='".$start_event."', end_event='".$end_event."', all_day='".$all_day."' WHERE id ='".$id."';");
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