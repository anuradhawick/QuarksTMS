<?php

/**
 * Description of TrainingDataDBHandler
 * 
 * @author Ravidu
 */
require_once dirname(__FILE__).'/../../Constants/DatabaseCredentials.php';

class TrainingDataDBHandler {

    public static function getMajorCategories() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return false;
        }
        $majorCategoryArray = array();
        $result = mysqli_query($conn, "SELECT * FROM `major_category`");
        $conn->close();
        while ($row = mysqli_fetch_array($result)) {
            $item = array();
            array_push($item, $row['idmajor_training']);
            array_push($item, $row['type']);
            array_push($majorCategoryArray, $item);
        }
        return $majorCategoryArray;
    }

    public static function getMinorCategories($id_major_training) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return false;
        }
        $minorCategoryArray = array();
        $result = mysqli_query($conn, "SELECT `idminor_training`, `type` FROM `minor_category` WHERE `idmajor_training`='$id_major_training'");
        $conn->close();
        while ($row = mysqli_fetch_array($result)) {
            $item = array();
            array_push($item, $row['idminor_training']);
            array_push($item, $row['type']);
            array_push($minorCategoryArray, $item);
        }
        return $minorCategoryArray;
    }

    public static function getAllLevelsOfTraining() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return false;
        }
        $levels = array();
        $result = mysqli_query($conn, "SELECT * FROM `level_of_training` ");
        $conn->close();
        while ($row = mysqli_fetch_array($result)) {
            $item = array();
            array_push($item, $row['idlevel_of_training']);
            array_push($item, $row['level']);
            array_push($levels, $item);
        }
        return $levels;
    }
    
    public static function getAllProgramTypes(){
        
         $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return false;
        }
        $programsarray = array();
        $result = mysqli_query($conn, "SELECT * FROM `program_type` ");
        $conn->close();
        while($row=  mysqli_fetch_array($result)){
            $program=array($row["idprogram_type"],$row["type"]);
            array_push($programsarray, $program);
        }
        return $programsarray;
}

}



