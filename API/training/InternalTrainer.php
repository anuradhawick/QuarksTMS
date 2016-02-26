<?php

/*
 * Coded by W.A. Anuradha Wickramarachchi
 */

class InternalTrainer {

    private $emp_number;
    private $training_id;

    public function __construct() {
        
    }

    public function getEmpNumber() {
        return $this->emp_number;
    }

    public function setEmpNumber($emp_number) {
        $this->emp_number = $emp_number;
    }

    public function getTrainingID() {
        return $this->training_id;
    }

    public function setTrainingID($trainingID) {
        $this->training_id = $trainingID;
    }

}
?>

