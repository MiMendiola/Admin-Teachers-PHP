<?php
    Class MessageModel extends Model{
        function __construct(){
            parent::__construct();
        }

        function saveMsg($user_send, $subject, $msg_text, $date, $users){
            try{
                $query = $this->db->connect()->prepare("INSERT INTO messages (msg_text,	subject, user_send, date) VALUES(:msg_text, :subject, :user_send, :date)");
                if($query->execute(array(":msg_text"=>$msg_text, ":subject"=> $subject, ":user_send"=>$user_send, ":date"=>$date)) == true){
                    //GET MSG ID 
                    $msg_id = $this->getRcientlyMsg($user_send, $subject, $date);
                    //SAVE RELATION
                    foreach($users AS $user_id){
                        $this->createRelationUserMsg($user_id, $msg_id);
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

        function createRelationUserMsg($user_id, $msg_id){
            try{
                $query = $this->db->connect()->prepare("INSERT INTO user_msg (message_id, user_id) VALUES(:msg_id, :user_id)");
                if($query->execute(array(":user_id"=>$user_id, ":msg_id"=> $msg_id)) == true){
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e){
                echo $e->getMessage();
                return NULL;
            }
        }

        function getMessageById($message_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM messages JOIN users ON messages.user_send = users.user_id WHERE messages.msg_id = :id ;");
                $query->execute(array(":id"=>$message_id));

                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $getAutor = $this->getUserById($row['user_send']);
                        $fullName = $getAutor->fullName();
                        $img = $getAutor->getPhoto();
                        $returnQuery[] = ["msg_id" => $row['msg_id'],"msg_text"=>$row['msg_text'], "subject"=>$row['subject'], "date"=>$row['date'], "user_create"=>$fullName,"view"=> $row['view'], "relation_id"=>$row['relation_id'], "creator_img"=> $img];
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

        //This function returns the users to whom a message has been sent.
        function getMsgUserSended($message_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM messages, users INNER JOIN user_msg ON users.user_id = user_msg.user_id WHERE messages.msg_id= :id ;");
                $query->execute(array(":id"=>$message_id));

                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $getAutor = $this->getUserById($row['user_send']);
                        $fullName = $getAutor->fullName();
                        $img = $getAutor->getPhoto();
                        $returnQuery[] = ["msg_id" => $row['msg_id'],"msg_text"=>$row['msg_text'], "subject"=>$row['subject'], "date"=>$row['date'], "user_create"=>$fullName,"view"=> $row['view'], "relation_id"=>$row['relation_id'], "creator_img"=> $img];
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

        function userGetMsgs($user_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM user_msg JOIN users ON users.user_id = user_msg.user_id JOIN messages ON messages.msg_id = user_msg.message_id WHERE user_msg.user_id = :id");
                $query->execute(array(":id"=>$user_id));
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $getAutor = $this->getUserById($row['user_send']);
                        $fullName = $getAutor->fullName();
                        $img = $getAutor->getPhoto();
                        $returnQuery[] = ["msg_id" => $row['msg_id'],"msg_text"=>$row['msg_text'], "subject"=>$row['subject'], "date"=>$row['date'], "user_create"=>$fullName,"view"=> $row['view'], "relation_id"=>$row['relation_id'], "creator_img"=> $img, "site_url"=>URL];
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

        function getMessageFull($relation_id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM user_msg JOIN users ON users.user_id = user_msg.user_id JOIN messages ON messages.msg_id = user_msg.message_id WHERE user_msg.relation_id = :id");
                $query->execute(array(":id"=>$relation_id));
                $returnQuery = array();

                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $getAutor = $this->getUserById($row['user_send']);
                        $fullName = $getAutor->fullName();
                        $img = $getAutor->getPhoto();
                        $returnQuery[] = ["msg_id" => $row['msg_id'],"msg_text"=>$row['msg_text'], "subject"=>$row['subject'], "date"=>$row['date'], "user_create"=>$fullName,"view"=> $row['view'], "relation_id"=>$row['relation_id'], "creator_img"=> $img, "site_url"=>URL];
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


        function updateView($id_relation){
            try {
                $query = $this->db->connect()->prepare("UPDATE user_msg SET view = 1 WHERE relation_id ='".$id_relation."';");
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

        function getRcientlyMsg($user_send, $subject, $date){
            try {
                $query = $this->db->connect()->prepare("SELECT msg_id FROM messages WHERE user_send = :user_send AND subject = :subject AND date = :date");
                $query->execute(array(":user_send"=>$user_send, ":subject"=> $subject, ":date"=> $date));

                if($query->rowCount() == 1){
                    while($row = $query->fetch()){
                        $returnQuery = $row['msg_id'];
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

        function getUserById($id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users WHERE user_id = :id");
                $query->execute(array(':id'=> $id));
                if($query->rowCount() > 0){
                    while($row = $query->fetch()){
                        $user = new User($row['user_id'], $row['name'],$row['last_name'],$row['passport'],$row['email'],$row['pass'],$row['normal_ip'],$row['hash'],$row['photo'],$row['user_type_id'], $row['first_time'], $row['open_acount']);
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

    }
?>