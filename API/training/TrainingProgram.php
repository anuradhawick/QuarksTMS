<?php

abstract class TrainingProgram {

    protected $idTraining;
    protected $name;
    protected $conductingAuthority;
    protected $mainProgramType;
    protected $trainerType;
    protected $levelOfTraining;
    protected $minorCategory;
    protected $programType;
    protected $requirements;
    protected $approval;
    protected $otherDetails;
    protected $trainer;
    protected $durations = array();
    protected $pdfUploads = array();
    protected $enrolTrainings = array();
    protected $programLinks = array();

    public function __construct() {
        
    }

    public abstract function getIdTraining();

    public abstract function setIdTraining($idtraining);

    public function getLevelOfTraining() {
        return $this->levelOfTraining;
    }

    public function setLevelOfTraining($levelOfTraining) {
        $this->levelOfTraining = $levelOfTraining;
    }

    public function getMinorCategory() {
        return $this->minorCategory;
    }

    public function setMinorCategory($minorCategory) {
        $this->minorCategory = $minorCategory;
    }

    public function getProgramType() {
        return $this->programType;
    }

    public function setProgramType($programType) {
        $this->programType = $programType;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getConductingAuthority() {
        return $this->conductingAuthority;
    }

    public function setConductingAuthority($conductingAuthority) {
        $this->conductingAuthority = $conductingAuthority;
    }

    public function getMainProgramType() {
        return $this->mainProgramType;
    }

    public function setMainProgramType($mainProgramType) {
        $this->mainProgramType = $mainProgramType;
    }

    public function getTrainerType() {
        return $this->trainerType;
    }

    public function setTrainerType($trainerType) {
        $this->trainerType = $trainerType;
    }

    public function getRequirements() {
        return $this->requirements;
    }

    public function setRequirements($requirements) {
        $this->requirements = $requirements;
    }

    public function getApproval() {
        return $this->approval;
    }

    public function setApproval($approval) {
        $this->approval = $approval;
    }

    public function getOtherDetails() {
        return $this->otherDetails;
    }

    public function setOtherDetails($otherDetails) {
        $this->otherDetails = $otherDetails;
    }

    public function getForeignTrainings() {
        return $this->foreignTrainings;
    }

    public function setForeignTrainings($foreignTrainings) {
        $this->foreignTrainings = $foreignTrainings;
    }

    public function getPdfUploads() {
        return $this->pdfUploads;
    }

    public function setPdfUploads($pdfUploads) {
        array_push($this->pdfUploads, $pdfUploads);
    }

    public function getEnrolTrainings() {
        return $this->enrolTrainings;
    }

    public function setEnrolTrainings($enrolTrainings) {
        array_push($this->enrolTrainings, $enrolTrainings);
    }

    public function getDuration() {
        return $this->durations;
    }

    public function setDuration($durations) {
        $this->durations = $durations;
    }

    public function getInhouseTrainings() {
        return $this->inhouseTrainings;
    }

    public function setInhouseTrainings($inhouseTrainings) {
        $this->inhouseTrainings = $inhouseTrainings;
    }

    public function getTrainer() {
        return $this->trainer;
    }

    public function setTrainer($trainer) {
        $this->trainer = $trainer;
    }

    public function getLocalTrainings() {
        return $this->localTrainings;
    }

    public function setLocalTrainings($localTrainings) {
        $this->localTrainings = $localTrainings;
    }

    public function getProgramLinkses() {
        return $this->programLinkses;
    }

    public function setProgramLinkses($programLinks) {
        array_push($this->programLinkses, $programLinks);
    }

}
