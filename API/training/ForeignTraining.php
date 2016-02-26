<?php

require_once 'TrainingProgram.php';

class ForeignTraining  extends TrainingProgram{
    
    private $foreignTrainingid;
    private $country;
    private $locationAddress;
    
    
    public function __construct() {
        
    }

    public static function withIds($idTraining,$country,$locationAddress ) {
        $instance=new self();
        $instance->country=$country;
        $instance->locationAddress=$locationAddress;
        $instance->idTraining=$idTraining;
        return $instance;
    }
    
    public static function withId($idTraining){
        $instance=new self();
        $instance->idTraining=$idTraining;
        return $instance;
    }
    
    
    public static function withParentRow($name,$conductingAuthority,$mainProgramType,$trainerType,$requirements,$approval,$otherDetails,$externalTrainerAssignments,$pdfUploads,$durations,$internalTrainerAssignments,$programLinks,$levelOfTraining,$minorCategory,$programType,$enrolTrainings,$country,$locationAddress){
        $instance=new self();
        $instance->name=$name;
        $instance->conductingAuthority=$conductingAuthority;
        $instance->mainProgramType=$mainProgramType;
        $instance->trainerType=$trainerType;
        $instance->requirements=$requirements;
        $instance->approval=$approval;
        $instance->otherDetails=$otherDetails;
        $instance->externalTrainerAssignments=$externalTrainerAssignments;
        $instance->pdfUploads=$pdfUploads;
        $instance->durations=$durations;
        $instance->internalTrainerAssignments=$internalTrainerAssignments;
        $instance->programLinks=$programLinks;
        $instance->levelOfTraining=$levelOfTraining;
        $instance->minorCategory=$minorCategory;
        $instance->programType=$programType;
        $instance->enrolTrainings=$enrolTrainings;
        $instance->country=$country;
        $instance->locationAddress=$locationAddress;
        return $instance;
    }
    
    public static function withRow($name,$conductingAuthority,$mainProgramType,$trainerType,$requirements,$approval,$otherDetails,$levelOfTraining,$minorCategory,$programType,$country,$locationAddress){
        $instance=new self();
        $instance->name=$name;
        $instance->conductingAuthority=$conductingAuthority;
        $instance->mainProgramType=$mainProgramType;
        $instance->trainerType=$trainerType;
        $instance->requirements=$requirements;
        $instance->approval=$approval;
        $instance->otherDetails=$otherDetails;
        $instance->levelOfTraining=$levelOfTraining;
        $instance->minorCategory=$minorCategory;
        $instance->programType=$programType;
        $instance->country=$country;
        $instance->locationAddress=$locationAddress;
        return $instance;
    }
    
    public function getIdTraining(){
        return $this->idTraining;
    }
    
    public function setIdTraining($idTraining){
        $this->idTraining=$idTraining;
    }
    
   
    public function getCountry(){
        return $this->country;
    }
    
    public function setCountry($country){
        $this->country=$country;
    }
    
    public function getLocationAddress(){
        return $this->locationAddress;
    }
    
    public function setLocationAddress($LocationAddress){
        $this->locationAddress=$LocationAddress;
                
    }

   

}
