<?php

class Duration{
    
    private $idduration;
    private $idTraining;
    private $from;
    private $to;
    private $noOfDays;
    private $noOfHours;
    private $closingDate;
    private $noOfParticipants;
    private $session;
   
    public function __construct() {
    }
    
    public static function withId($idTraining){
         $instance=new self();
         $instance->idTraining = $idTraining;
         return $instance;
    }
    
    public static function withRow($idTraining,$from,$to,$noOfDays,$noOfHours,$closingDate,$noOfParticipants,$session) {
       $instance=new self();
       $instance->idTraining = $idTraining;
       $instance->from = $from;
       $instance->to = $to;
       $instance->noOfDays = $noOfDays;
       $instance->noOfHours = $noOfHours;
       $instance->closingDate = $closingDate;
       $instance->noOfParticipants = $noOfParticipants;
       $instance->session = $session;
       return $instance;
    }
   
    public function getIdduration() {
        return $this->idduration;
    }
    
    public function setIdduration($idduration) {
        $this->idduration = $idduration;
    }
    
    public function getIdTraining() {
        return $this->idTraining;
    }
    
    public function setIdTraining($idTraining) {
        $this->idTraining = $idTraining;
    }
    
    public function getFrom() {
        return $this->from;
    }
    
    public function setFrom($from) {
        $this->from = $from;
    }
    
    public function getTo() {
        return $this->to;
    }
    
    public function setTo($to) {
        $this->to = $to;
    }
    
    public function getNoOfDays() {
        return $this->noOfDays;
    }
    
    public function setNoOfDays($noOfDays) {
        $this->noOfDays = $noOfDays;
    }
    
    public function getNoOfHours() {
        return $this->noOfHours;
    }
    
    public function setNoOfHours($noOfHours) {
        $this->noOfHours = $noOfHours;
    }
    
    public function getClosingDate() {
        return $this->closingDate;
    }
    
    public function setClosingDate($closingDate) {
        $this->closingDate = $closingDate;
    }
    
    public function getNoOfParticipants() {
        return $this->noOfParticipants;
    }
    
    public function setNoOfParticipants($noOfParticipants) {
        $this->noOfParticipants = $noOfParticipants;
    }
    
    public function getSession() {
        return $this->session;
    }
    
    public function setSession($session) {
        $this->session = $session;
    }
}

