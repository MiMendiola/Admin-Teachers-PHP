<?php
Class User {
    private $user_id;
    private $name;
    private $last_name;
    private $passport;
    private $email;
    private $pass;
    private $normal_ip;
    private $hash;
    private $photo;
    private $firstTime;
    private $user_type_id;
    private $openAcount;

    function __construct($user_id, $name, $last_name, $passport, $email, $pass, $normal_ip, $hash, $photo, $user_type_id, $firstTime, $openAcount){
        $this->user_id = $user_id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->passport = $passport;
        $this->email = $email;
        $this->pass = $pass;
        $this->normal_ip = $normal_ip;
        $this->hash = $hash;
        $this->photo = $photo;
        $this->user_type_id = $user_type_id;
        $this->firstTime = $firstTime;
        $this->openAcount = $openAcount;
    }

    // GETTERS AND SETTERS
    function getUser_id(){
        return $this->user_id;
    }
    function getFirstTime(){
        return $this->firstTime;
    }

    function getName(){
        return $this->name;
    }

    function getLast_name(){
        return $this->last_name;
    }
    function getPassport(){
        return $this->passport;
    }
    function getEmail(){
        return $this->email;
    }
    function getPass(){
        return $this->pass;
    }
    function getNormal_ip(){
        return $this->normal_ip;
    }
    function getHash(){
        return $this->hash;
    }
    function getPhoto(){
        return $this->photo;
    }
    function getUser_type_id(){
        return $this->user_type_id;
    }

    function setName ($name){
        $this->name = $name;
    }
    function setFirstTime ($firstTime){
        $this->firstTime = $firstTime;
    }
    function setLast_name ($last_name){
        $this->last_name = $last_name;
    }
    function setPassport ($passport){
        $this->passport = $passport;
    }
    function setEmail ($email){
        $this->email = $email;
    }
    function setPass ($pass){
        $this->pass = $pass;
    }
    function setNormal_ip ($normal_ip){
        $this->normal_ip = $normal_ip;
    }
    function setPhoto ($photo){
        $this->photo = $photo;
    }
    function setUser_type_id ($user_type_id){
        $this->user_type_id = $user_type_id;
    }

    function fullName(){
        return $this->last_name.", ".$this->name;
    }

    /**
     * @return mixed
     */
    public function getOpenAcount()
    {
        return $this->openAcount;
    }

    /**
     * @param mixed $openAcount
     */
    public function setOpenAcount($openAcount)
    {
        $this->openAcount = $openAcount;
    }

    public function openAcount(){
        if($this->openAcount == 1){
            return true;
        } else {
            return false;
        }
    }
}

?>