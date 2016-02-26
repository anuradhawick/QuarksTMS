<?php

require_once 'TrainingProgram.php';

class InhouseTraining extends TrainingProgram {

    private $location;

    public function __construct() {
        
    }

    public static function withId($idtraining) {
        $instance = new self();
        $instance->idTraining = $idtraining;
        return $instance;
    }

    public static function withParentRow($levelOfTraining, $minorCategory, $programType, $name, $conductingAuthority, $mainProgramType, $trainerType, $requirements, $approval, $otherDetails, $externalTrainerAssignments, $pdfUploads, $enrolTrainings, $durations, $internalTrainerAssignments, $programLinkses, $location) {
        $instance = new self();
        $instance->levelOfTraining = $levelOfTraining;
        $instance->minorCategory = $minorCategory;
        $instance->programType = $programType;
        $instance->name = $name;
        $instance->conductingAuthority = $conductingAuthority;
        $instance->mainProgramType = $mainProgramType;
        $instance->trainerType = $trainerType;
        $instance->requirements = $requirements;
        $instance->approval = $approval;
        $instance->otherDetails = $otherDetails;
        $instance->externalTrainerAssignments = $externalTrainerAssignments;
        $instance->pdfUploads = $pdfUploads;
        $instance->enrolTrainings = $enrolTrainings;
        $instance->durations = $durations;
        $instance->internalTrainerAssignments = $internalTrainerAssignments;
        $instance->programLinkses = $programLinkses;
        $instance->location = $location;
        return $instance;
    }

   public static function withRow($name, $conductingAuthority, $mainProgramType, $trainerType, $requirements, $approval, $otherDetails, $levelOfTraining, $minorCategory, $programType, $location) {
        $instance = new self();
        $instance->name = $name;
        $instance->conductingAuthority = $conductingAuthority;
        $instance->mainProgramType = $mainProgramType;
        $instance->trainerType = $trainerType;
        $instance->requirements = $requirements;
        $instance->approval = $approval;
        $instance->otherDetails = $otherDetails;
        $instance->levelOfTraining = $levelOfTraining;
        $instance->minorCategory = $minorCategory;
        $instance->programType = $programType;
        $instance->location = $location;
        return $instance;
    }

  

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function getIdTraining() {
        return $this->idTraining;
    }

    public function setIdTraining($idtraining) {
        $this->idTraining=$idtraining;
    }

}
