<?php
    Class Forum {
        private $id;
        private $user;
        private $msg;
        private $replay;
        private $course;
        private $date;

        function __construct($id, $user, $msg, $course, $date, $replay =0){
            $this->id = $id;
            $this->user = $user;
            $this->msg = $msg;
            $this->replay = $replay;
            $this->course = $course;
            $this->date = $date;    
        }

        /**
         * Get the value of id
         */ 
        public function getId()
        {
                return $this->id;
        }

        /**
         * Get the value of user
         */ 
        public function getUser()
        {
                return $this->user;
        }

        /**
         * Set the value of user
         *
         * @return  self
         */ 
        public function setUser($user)
        {
                $this->user = $user;

                return $this;
        }

        /**
         * Get the value of msg
         */ 
        public function getMsg()
        {
                return $this->msg;
        }

        /**
         * Set the value of msg
         *
         * @return  self
         */ 
        public function setMsg($msg)
        {
                $this->msg = $msg;

                return $this;
        }

        /**
         * Get the value of replay
         */ 
        public function getReplay()
        {
                return $this->replay;
        }

        /**
         * Get the value of course
         */ 
        public function getCourse()
        {
                return $this->course;
        }

        /**
         * Get the value of date
         */ 
        public function getDate()
        {
                return $this->date;
        }

        /**
         * Set the value of reply
         *
         * @return  self
         */ 
        public function setReply($reply)
        {
                $this->reply = $reply;

                return $this;
        }

        /**
         * Get the value of reply
         */ 
        public function getReply()
        {
                return $this->reply;
        }
    }

?>