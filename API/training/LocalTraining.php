<?php

require_once 'TrainingProgram.php';

class LocalTraining extends TrainingProgram {

    private $place;
    private $locationAddress;

    public static function withId($idtraining) {
        $instance = new self();
        $instance->idTraining = $idtraining;
        return $instance;
    }

    public static function withParentRow($levelOfTraining, $minorCategory, $programType, $name, $conductingAuthority, $mainProgramType, $trainerType, $requirements, $approval, $otherDetails, $externalTrainerAssignments, $pdfUploads, $enrolTrainings, $durations, $internalTrainerAssignments, $programLinkses, $place, $locationAddress) {
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
        $instance->place = $place;
        $instance->locationAddress = $locationAddress;
        return $instance;
    }

    public static function withRow($name, $conductingAuthority, $mainProgramType, $trainerType, $requirements, $approval, $otherDetails, $levelOfTraining, $minorCategory, $programType, $place, $locationAddress) {
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
        $instance->place = $place;
        $instance->locationAddress = $locationAddress;
        return $instance;
    }

    public function getIdTraining() {
        return $this->idTraining;
    }

    public function setIdTraining($idtraining) {
        $this->idTraining = $idtraining;
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace($place) {
        $this->place = $place;
    }

    public function getLocationAddress() {
        return $this->locationAddress;
    }

    public function setLocationAddress($locationAddress) {
        $this->locationAddress = $locationAddress;
    }

}
