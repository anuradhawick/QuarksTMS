<?php

class LevelOfTraining{
    
    private $idlevelOfTraining;
    private $level;
    private $trainingPrograms =array();
    
    public function __construct() {
        
    }
    
    public static function withRow($level,$trainingPrograms){
        $instance=new self();
        $instance->level=$level;
        $instance->trainingPrograms=$trainingPrograms;
        return $instance;
    }
    
    public static function withLevel($level){
        $instance=new self();
        $instance->level=$level;
        return $instance;
    }
    
    public function getIdlevelOfTraining(){
        return $this->idlevelOfTraining;
    }
    
    public function setIdlevelOfTraining($idlevelOftraining){
        $this->idlevelOfTraining=$idlevelOftraining;
    }
    
    public function getLevel(){
        return $this->level;
    }
    
    public function setLevel($level){
        $this->level=$level;
    }
    
    public function getTrainingPrograms(){
        return $this->trainingPrograms;
    }
    
    public function setTrainingPrograms($trainingPrograms){
        $this->trainingPrograms=$trainingPrograms;
    }
  
}

