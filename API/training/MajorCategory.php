<?php

class MajorCategory{
    
     private $idmajorTraining;
     private $type;
     private $minorCategories = array();
     
     public function __construct() {
         
     }
     
     public static function withId($idmajorTraining){
         $instance=new self();
         $instance->idmajorTraining=$idmajorTraining;
         return $instance;
     }
     
     public static function withType($type){
         $instance=new self();
         $instance->type=$type;
         return $instance;
     }
     
     public static function withRow($minorCategories,$type){
         $instance=new self();
         $instance->minorCategories=$minorCategories;
         $instance->type=$type;
         return $instance;
     }
     
     public function getIdmajorTraining(){
         return $this->idmajorTraining;
     }
     
     public function setIdmajorTraining($idmajorTraining){
         $this->idmajorTraining=$idmajorTraining;
     }
     
     public function getType(){
         return $this->type;
     }
     
     public function setType($type){
         $this->type=$type;
     }
     
     public function getMinorcategories(){
         return $this->minorCategories;
     }
     
     public function setMinorCategories($minorCategories){
         $this->minorCategories=$minorCategories;
     }
  

}

