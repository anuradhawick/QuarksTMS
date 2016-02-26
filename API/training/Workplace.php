<?php

/*
* ***** Coded by D. R. ATAPATTU *****
*/
class Workplace{
    private $id;
    private $workplace_name;
    private $address;
    
    public function __construct($workplace_name, $address) {
        $this->workplace_name=$workplace_name;
        $this->address=$address;
    }
    
    public function setID($id){
        $this->id=$id;
    }
    
    public function setWorkplaceName($workplace_name){
        $this->workplace_name=$workplace_name;
    }
    
    public function setAddress($address){
        $this->address=$address;
    }
    
    public function getID(){
        return $this->id;
    }
    
    public function getWorkplaceName(){
        return $this->workplace_name;
    }
    
    public function getAddress(){
        return $this->address;
    }
}
?>