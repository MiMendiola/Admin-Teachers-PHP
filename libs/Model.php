<?php
    Class Model {

        function __construct(){
            $this->db = new Database();
        }

        function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }

        function getUserById($id){
            try {
                $query = $this->db->connect()->prepare("SELECT * FROM users WHERE user_id = :id");
                $query->execute(array(':id'=> $id));
                if($query->rowCount() == 1){
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

    }

?>