<?php

class MinorCategory{
    
    private $idminorTraining;
    private $majorCategory;
    private $type;
    private $trainingPrograms = array();
    
    public function __construct() {
        
    }
    
    public static function withId($majorCategory){
        $instance=new MinorCategory();
        $instance->majorCategory=$majorCategory;
        return $instance;
    }
    
    public static function withType($type,$majorCategory){
        $instance=new self();
        $instance->type=$type;
        $instance->majorCategory=$majorCategory;
        return $instance;
    }
    
    public static function withRow($majorCategory,$type,$trainingPrograms){
        $instance=new MinorCategory();
        $instance->majorCategory=$majorCategory;
        $instance->trainingPrograms=$trainingPrograms;
        $instance->type=$type;
        return $instance;
        
    }
    
    public function getIdminorTraining(){
        return $this->idminorTraining;
    }
    
    public function setIdminorTraining($idminorTraining){
        $this->idminorTraining=$idminorTraining;
    }
    
    public function getMajorCategory(){
        return $this->majorCategory;
    }
    
    public function setMajorCategory($majorcategory){
        $this->majorCategory=$majorcategory;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($type){
        $this->type=$type;
    }
    
    public function getTrainingPrograms(){
        return $this->trainingPrograms;
    }
    
    public function setTrainingPrograms($trainingPrograms){
        $this->trainingPrograms=$trainingPrograms;
    }
  
}

