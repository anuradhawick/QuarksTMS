<?php

class ProgramLinks{
    
    private $idprogramLinks;
    private $trainingProgram;
    private $link;
    private $linkName;
    
    public function __construct() {
        
    }
    
    public static function withId($trainingProgram){
        $instance=new ProgramLinks();
        $instance->trainingProgram=$trainingProgram;
        return $instance;
    }
    
    public static function withRow($trainingProgram,$link,$linkname){
        $instance=new ProgramLinks();
        $instance->trainingProgram=$trainingProgram;
        $instance->link=$link;
        $instance->linkName=$linkname;
        return $instance;
    }
    
    public function getIdprogramLinks(){
        return $this->idprogramLinks;
    }
    
    public function setIdprogramLinks($idprogramLinks){
        $this->idprogramLinks=$idprogramLinks;
    }
    
    public function getTrainingProgram(){
        return $this->trainingProgram;
    }
    
    public function setTrainingProgram($trainingProgram){
        $this->trainingProgram=$trainingProgram;
    }
    
    public function getLink(){
        return $this->link;
    }
    
    public function setLink($link){
        $this->link=$link;
    }
    
    public function getLinkName(){
        return $this->linkName;
    }
    
    public function setLinkName($linkName){
        $this->linkName=$linkName;
    }

}

