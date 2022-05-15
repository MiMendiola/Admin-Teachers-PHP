<?php

    Class Database{
        private $host;
        private $db;
        private $user;
        private $password;

        public function __construct(){
               $this->db = constant('DB');
               $this->host = constant('HOST');
               $this->user = constant('USER');
               $this->password = constant('PASSWORD');
        }

        public function connect() {
            try{
                $opc = array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                );

                $dsn = "mysql:host=".$this->host.";dbname=".$this->db;
                $pdo = new PDO($dsn, $this->user, $this->password, $opc);
                
                return $pdo;
            } catch(PDOException $e){
                print_r('Error connection: '. $e->getMessage());
            }
        }
    }

?>