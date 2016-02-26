<?php


class Employee {
    
     private $empNumber;
     private $employeeId;
     private $empLastname;
     private $empFirstname;
     private $empNicNo;
     private $empNicDate;
     private $empBirthday;
     private $loginSessionses =array();
     private $personUserLevels = array();
     private $internalTrainerAssignments = array();
     private $logins = array();
     private $enrolTrainings = array();
     private $personWorkplaces = array();
     private $trainingRequests = array();

    
	
    public static function withId($empNumber) {
        $instance=new self();
        $instance->empNumber = $empNumber;
        return $instance;
    }
    public static function withRow($empNumber, $employeeId, $empLastname,$empFirstname, $empNicNo, $empNicDate, $empBirthday, $loginSessionses, $personUserLevels, $internalTrainerAssignments, $logins, $enrolTrainings, $personWorkplaces, $trainingRequests) {
       $instance=new self(); 
       $instance->empNumber = $empNumber;
       $instance->employeeId = $employeeId;
       $instance->empLastname = $empLastname;
       $instance->empFirstname = $empFirstname;
       $instance->empNicNo = $empNicNo;
       $instance->empNicDate = $empNicDate;
       $instance->empBirthday = $empBirthday;
       $instance->loginSessionses = $loginSessionses;
       $instance->personUserLevels = $personUserLevels;
       $instance->internalTrainerAssignments = $internalTrainerAssignments;
       $instance->logins = $logins;
       $instance->enrolTrainings = $enrolTrainings;
       $instance->personWorkplaces = $personWorkplaces;
       $instance->trainingRequests = $trainingRequests;
       return $instance;
    }
   
    public function getEmpNumber() {
        return $this->empNumber;
    }
    
    public function setEmpNumber($empNumber) {
        $this->empNumber = $empNumber;
    }
    public function getEmployeeId() {
        return $this->employeeId;
    }
    
    public function setEmployeeId($employeeId) {
        $this->employeeId = $employeeId;
    }
    public function getEmpLastname() {
        return $this->empLastname;
    }
    
    public function setEmpLastname($empLastname) {
        $this->empLastname = $empLastname;
    }
    public function getEmpFirstname() {
        return $this->empFirstname;
    }
    
    public function setEmpFirstname($empFirstname) {
        $this->empFirstname = $empFirstname;
    }
    
    public function getEmpNicNo() {
        return $this->empNicNo;
    }
    
    public function setEmpNicNo($empNicNo) {
        $this->empNicNo = $empNicNo;
    }
    public function getEmpNicDate() {
        return $this->empNicDate;
    }
    
    public function setEmpNicDate($empNicDate) {
        $this->empNicDate = $empNicDate;
    }
    public function getEmpBirthday() {
        return $this->empBirthday;
    }
    
    public function setEmpBirthday($empBirthday) {
        $this->empBirthday = $empBirthday;
    }
    public function getLoginSessionses() {
        return $this->loginSessionses;
    }
    
    public function setLoginSessionses($loginSessionses) {
        $this->loginSessionses = $loginSessionses;
    }
    public function getPersonUserLevels() {
        return $this->personUserLevels;
    }
    
    public function setPersonUserLevels($personUserLevels) {
        $this->personUserLevels = $personUserLevels;
    }
    public function getInternalTrainerAssignments() {
        return $this->internalTrainerAssignments;
    }
    
    public function setInternalTrainerAssignments($internalTrainerAssignments) {
        $this->internalTrainerAssignments = $internalTrainerAssignments;
    }
    public function getLogins() {
        return $this->logins;
    }
    
    public function setLogins($logins) {
        $this->logins = $logins;
    }
    public function getEnrolTrainings() {
        return $this->enrolTrainings;
    }
    
    public function setEnrolTrainings($enrolTrainings) {
        $this->enrolTrainings = $enrolTrainings;
    }
    public function getPersonWorkplaces() {
        return $this->personWorkplaces;
    }
    
    public function setPersonWorkplaces($personWorkplaces) {
        $this->personWorkplaces = $personWorkplaces;
    }
    public function getTrainingRequests() {
        return $this->trainingRequests;
    }
    
    public function setTrainingRequests($trainingRequests) {
        $this->trainingRequests = $trainingRequests;
    }



}
