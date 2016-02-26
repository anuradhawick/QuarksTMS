<?php

/*
 * Coded by W.A.Anuradha Wickramarachchi
 * 
 * This class is the external trainer class which represent the external trainers
 * This contains details of the external trainer sufficent for management
 */

class ExternalTrainer {

    private $name;
    private $training;
    private $qualifications;
    private $trainer_id;

    public function __construct() {
        
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getTraining() {
        return $this->training;
    }

    public function setTraining($training) {
        $this->training = $training;
    }

    public function getQualifications() {
        return $this->qualifications;
    }

    public function setQualifications($qualifications) {
        $this->qualifications = $qualifications;
    }

    public function getTrainerID() {
        return $this->trainer_id;
    }

    public function setTrainerID($id) {
        $this->trainer_id = $id;
    }

}

?>