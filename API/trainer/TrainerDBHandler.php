<?php

/*
 * Coded by W.A.Anuradha Wickramarachchi
 * 
 * Used to add or get objects of training programs
 */


require_once dirname(__FILE__) . '/../Constants/DatabaseCredentials.php';

//require_once '../Constants/DatabaseCredentials.php';

class TrainerDBHandler {

    public function __construct() {
        
    }

    public static function addExternalTrainer(ExternalTrainer $trainer) {
        $name = $trainer->getName();
        $qualifications = $trainer->getQualifications();

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return False;
        }

        $stmt_extTr = $conn->prepare("INSERT INTO `Training`.`external_trainer` (`name`, `qualifications`) VALUES (?, ?)");
        if ($stmt_extTr) {
            $stmt_extTr->bind_param("ss", $name, $qualifications);
            $stmt_extTr->execute();
            $stmt_extTr->close();
            $conn->close();
            return True;
        }

        $conn->close();
        return False;
    }

    public static function addInternalTrainer(InternalTrainer $trainer) {
        
    }

    public static function getExternalTrainers() {
        $trainers = array();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return False;
        }

        $result = mysqli_query($conn, "SELECT * FROM Training.external_trainer");
        while ($row = mysqli_fetch_array($result)) {
            $trainerArray = array();
            array_push($trainerArray, $row['idoutside_trainer']);
            array_push($trainerArray, $row['name']);
            array_push($trainerArray, $row['qualifications']);
            array_push($trainers, $trainerArray);
        }

        $conn->close();
        return $trainers;
    }

    public static function getInternalTrainers() {
        $trainers = array();
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Connection failed" . $conn->connect_error);
            return False;
        }

        $result = mysqli_query($conn, "SELECT hs_hr_employee.* FROM hs_hr_employee join internal_trainer_assignment on hs_hr_employee.emp_number = internal_trainer_assignment.emp_number");
        while ($row = mysqli_fetch_array($result)) {
            $trainerArray = array();
            array_push($trainerArray, $row['emp_number']);
            array_push($trainerArray, $row['employee_id']);
            array_push($trainerArray, $row['emp_firstname'] . " " . $row['emp_lastname']);
            array_push($trainers, $trainerArray);
        }

        $conn->close();
        return $trainers;
    }

}
?>

