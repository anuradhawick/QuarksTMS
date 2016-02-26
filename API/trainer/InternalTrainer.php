<?php

/*
 * Coded by W.A. Anuradha Wickramarachchi
 */

class InternalTrainer {

    private $emp_number;
    private $training;

    public function __construct() {
        
    }

    public function getEmpNumber() {
        return $this->emp_number;
    }

    public function setEmpNumber($emp_number) {
        $this->emp_number = $emp_number;
    }

    public function getTraining() {
        return $this->training;
    }

    public function setTraining($training) {
        $this->training = $training;
    }

}
?>

