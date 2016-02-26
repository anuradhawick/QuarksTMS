<?php

class PdfUpload{
    
    private $idpdfUpload;
    private $trainingProgram;
    private $name;
    private $pdfLink;
    
    public function __construct() {
        
    }
    
    public static function withId($trainingProgram){
        $instance=new PdfUpload();
        $instance->trainingProgram=$trainingProgram;
        return $instance;
    }
    
    public static function withRow($trainingProgram,$name,$pdfLink){
        $instance=new PdfUpload();
        $instance->trainingProgram=$trainingProgram;
        $instance->name=$name;
        $instance->pdfLink=$pdfLink;
        return $instance;
    }
    
    public function getIdpdfUpload(){
        return $this->idpdfUpload;
    }
    
    public function setIdpdfUpload($idpdfUpload){
        $this->idpdfUpload=$idpdfUpload;
    }
    
    public function getTrainingProgram(){
        return $this->trainingProgram;
    }
    
    public function settrainingProgram($trainingProgram){
        $this->trainingProgram=$trainingProgram;
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function setName($name){
        $this->name=$name;
    }
    
    public function getPdfLink(){
        return $this->pdfLink;
    }
    
    public function setPdfLink($pdfLink){
        $this->pdfLink=$pdfLink;
    }
  
}

