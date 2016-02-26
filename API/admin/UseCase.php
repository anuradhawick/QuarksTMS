<?php
/**
* Coded by Pamoda Wimalasiri
*/
class UseCase
{
	private $usecase_ID;
	private $usecase_name;
	
        public function __construct(){
            
        }
        
        public static function withRow($usecase_ID,$usecase_name){
            $instance=new self();
            $instance->usecase_ID=$usecase_ID;
            $instance->usecase_name=$usecase_name;
            return $instance;
        }

	public function getUsecase_ID(){
		return $this->usecase_ID;
	}
        
        public function setUsecase_ID($usecase_ID){
            $this->usecase_ID=$usecase_ID;
        }

	public function getUsecase_name(){
		return $this->usecase_name;
	}

	public function setUsecase_name($usecase_name){
		$this->usecase_name=$usecase_name;
	}
            


}
