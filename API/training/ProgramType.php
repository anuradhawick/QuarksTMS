<?php

class ProgramType{
    
    private $idprogramType;
    private $type;
    private $trainingPrograms = array();

    public function __construct() {
        
    }
    
    public static function withRow($type,$trainingPograms){
        $instance=new ProgramType();
        $instance->type=$type;
        $instance->trainingPrograms=$trainingPograms;
        return $instance;        
    }
    
    public static function withType($type){
        $instance=new self();
        $instance->type=$type;
        return $instance;
    }
    
    public function getIdprogramType(){
        return $this->idprogramType;
    }
    
    public function  setIdprogramType($idProgramType){
        $this->idprogramType=$idProgramType;
    }
    
    public function getType(){
        return $this->type;
    }
    
    public function setType($type){
        $this->type=$type;
    }
    
    public function getTrainigPrograms(){
        return $this->trainingPrograms;
    }
    
    public function setTrainingPrograms($trainingPrograms){
        $this->trainingPrograms=$trainingPrograms;
    }
    

}

