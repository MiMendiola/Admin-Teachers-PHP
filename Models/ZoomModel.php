<?php
    Class ZoomModel extends Model{
        function __construct(){
            parent::__construct();
        }

        public function is_table_empty() {
            $result = $this->db->connect()->prepare("SELECT id FROM zoom_oauth WHERE provider = 'zoom'");
            $result->execute();
            if($result->rowCount() != 0) {
                return false;
            }
            return true;
        }
      
        public function get_access_token() {
            $sql = $this->db->connect()->prepare("SELECT provider_value FROM zoom_oauth WHERE provider = 'zoom'");
            $sql->execute();
            if($sql->rowCount() > 0){
                $result = array();
                while($row = $sql->fetch()){
                    $result['provider_value'] = $row['provider_value'];
                }
            } else {
                $result['provider_value'] = "access_token";
            }

            return json_decode($result['provider_value']);
        }
      
        public function get_refersh_token() {
            $result = $this->get_access_token();
            return $result->refresh_token;
        }
      
        public function update_access_token($token) {
            if($this->is_table_empty()) {
               $sql = $this->db->connect()->prepare("INSERT INTO zoom_oauth(provider, provider_value) VALUES('zoom', '$token')");
                $sql->execute();
            } else {
                $sql = $this->db->connect()->prepare("UPDATE zoom_oauth SET provider_value = '$token' WHERE provider = 'zoom'");
                $sql->execute();
            }
        }
        
    }
?>