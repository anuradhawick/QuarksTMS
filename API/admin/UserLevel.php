<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserLevel
 *
 * @author Pamoda
 */
class UserLevel {

    private $userLevel_ID;
    private $userLevel_type;
    private $useCases=array();
    private $users=array();

    public function __construct() {
        
    }
    
    public static function withId($type){
        $instance=new self();
        $instance->userLevel_type=$type;
        return $instance;
    }
    
    public static function withRow($userlevel_ID,$userLevel_type,$usecases,$users){
        $instance=new self();
        $instance->userLevel_ID=$userlevel_ID;
        $instance->userLevel_type=$userLevel_type;
        $instance->users=$users;
        $instance->useCases=$usecases;
        return $instance;
    }

    public function getUserLevel_ID() {
        return $this->userLevel_ID;
    }

    public function setUserLevel_ID($userLevel_ID){
        $this->userLevel_ID=$userLevel_ID;
        
    }
    public function getUserLevel_type() {
        return $this->userLevel_type;
    }

    public function setUserLevel_type($userLevel_type) {
        $this->userLevel_type = $userLevel_type;
    }

    public function getUseCases() {
        return $this->useCases;
    }
    
    public function setUseCases($useCases) {
        $this->useCases=$useCases;
    }

    public function getUsers() {
        return $this->users;
    }
     
    public function setUsers($users) {
        $this->users=$users;
    }
}
