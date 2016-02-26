<?php

/*
 * ***** Coded by D. R. ATAPATTU *****
 */

require_once dirname(__FILE__).'/../../Constants/DatabaseCredentials.php';

class WorkplaceDBHandler {

    public function addNewWorkplace($workplace) {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            die("Database connection failed. " . $conn->connect_error);
        } else {
            $stmt = $conn->prepare("INSERT INTO workplace (workplace_name, addr) VALUES (?, ?)");
            $stmt->bind_param("ss", $workplace->getWorkplaceName(), $workplace->getAddress());
            $stmt->execute();
            $stmt->close();
        }
        $conn->close();
    }

    public function getAllWorkplaces() {
        $workplaceArray = array();
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT * FROM workplace;";
        $result = mysqli_query($dbc, $query) or die("Get all workplaces form DB failed. " . mysqli_error($dbc));
        mysqli_close($dbc);
        while ($row = mysqli_fetch_row($result)) {
            $workplace = new Workplace($row[1], $row[2]);
            $workplace->setID($row[0]);
            array_push($workplaceArray, $workplace);
        }
        return $workplaceArray;
    }

    public function addEmployeeToWorkplace($emp_number, $idworkplace) {
        $workplaceArray = array();
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "INSERT INTO `person_workplace`(`idworkplace`, `emp_number`) VALUES ('$idworkplace', '$emp_number');";
        $result = mysqli_query($dbc, $query) or die("Add employee to workplace failed. " . mysqli_error($dbc));
        mysqli_close($dbc);
    }

    public static function getWorkplace($emp_number) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT person_workplace.idworkplace, `workplace_name`, `addr` FROM `person_workplace` JOIN `workplace` ON person_workplace.idworkplace=workplace.idworkplace WHERE `emp_number`='$emp_number';";
        $result = mysqli_query($dbc, $query) or die("Get workplace form DB failed. " . mysqli_error($dbc));
        mysqli_close($dbc);
        $row = mysqli_fetch_row($result);

        $workplace = new Workplace($row[1], $row[2]);
        $workplace->setID($row[0]);
        return $workplace;
    }

}

?>
