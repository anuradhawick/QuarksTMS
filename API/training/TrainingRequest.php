<?php

class TrainingRequest{
    
    private $idtrainingRequest;
    private $employee;
    private $subject;
    private $type;
    private $description;
    private $importance;
    
    public function __construct() {
        
    }
    
    public static function withRow($employee,$subject,$type,$description,$importance){
        $instance=new TrainingRequest();
        $instance->employee=$employee;
        $instance->subject=$subject;
        $instance->type=$type;
        $instance->description=$description;
        $instance->importance=$importance;
        return $instance;
    }
    
    public function getIdtrainingRequest(){
        return $this->idtrainingRequest;
    }
    
    public function setIdtrainingRequest($idtrainingRequest){
        $this->idtrainingRequest=$idtrainingRequest;
    }
    
    public function getEmployee(){
        return $this->employee;
    }
    
    public function setEmployee($employee){
        $this->employee=$employee;
    }
    
    public function getTrainingSubject(){
        return $this->subject;
    }
    
    public function setTrainingSubject($subject){
        $this->subject=$subject;
    }
    
    public function getTrainingType(){
        return $this->type;
    }
    
    public function setTrainingType($type){
        $this->type=$type;
    }
    
    public function getTrainingDescription(){
        return $this->description;
    }
    
    public function setTrainingDescription($description){
        $this->description=$description;
    }
    
    public function getTrainingImportance(){
        return $this->importance;
    }
    
    public function setTrainingImportance($importance){
        $this->importance=$importance;
    }
    
    
  
}
