<?php
class Person{ 
    protected $name;
    protected $phoneNumber;
    protected $email;
    protected $team_name;
    protected $description;
    public function __construct($name, $phoneNumber, $email, $team_name, $description){
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
        $this->team_name= $team_name;
        $this->description = $description;
    }
    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getPhoneNumber(){
        return $this->phoneNumber;
    }
    public function setPhoneNumber($phoneNumber){
        $this->phoneNumber = $phoneNumber;
    }
    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }
    public function getTeamName(){
        return $this->team_name;
    }
    public function setTeamName($team_name){
        $this->team_name = $team_name;
    }
    public function getSDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }

}

?>
