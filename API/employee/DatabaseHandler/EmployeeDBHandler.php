<?php

/*
 * ***** Coded by D. R. ATAPATTU *****
 */


require_once dirname(__FILE__) . '/../../Constants/DatabaseCredentials.php';

class EmployeeDBHandler {

    public static function getEmployeeById($emp_number) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT * FROM `hs_hr_employee` WHERE `emp_number`='$emp_number';";
        $result = mysqli_query($dbc, $query) or die("Get employee from DB failed. " . mysqli_error($dbc));
        $row = mysqli_fetch_row($result);
        mysqli_close($dbc);

//        $employee = array();
//        array_push($employee, $row[0]);     //Empployee number
//        array_push($employee, $row[1]);     //Id
//        array_push($employee, $row[2]);     //Last name
//        array_push($employee, $row[3]);     //First name
//        array_push($employee, $row[4]);     //NIC
//        array_push($employee, $row[5]);     //NIC date
//        array_push($employee, $row[6]);     //Birthday
//        return $employee;
        $employee = new Employee();
        $employee->setEmpNumber($row[0]);
        $employee->setEmployeeId($row[1]);
        $employee->setEmpLastname($row[2]);
        $employee->setEmpFirstname($row[3]);
        $employee->setEmpNicNo($row[4]);
        $employee->setEmpNicDate($row[5]);
        $employee->setEmpBirthday($row[6]);


        $nice = $employee->getEmpNicNo();
        if (intval($nice[2]) >= 5) {
            $employee->setEmpGender("Female");
        } else {
            $employee->setEmpGender("Male");
        }
        return $employee;
    }

    public static function searchEmployeeById($employee_id) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT * FROM Training.hs_hr_employee WHERE `employee_id` Like '" . $employee_id . "%';";
        $result = mysqli_query($dbc, $query) or die("Get employee from DB failed. " . mysqli_error($dbc));
        mysqli_close($dbc);

        $trainers = array();
        while ($row = mysqli_fetch_array($result)) {
            $trainer = array();
            array_push($trainer, $row['emp_number']);
            array_push($trainer, $row['employee_id']);
            array_push($trainer, $row['emp_firstname']);
            array_push($trainer, $row['emp_lastname']);
            array_push($trainers, $trainer);
        }
        return $trainers;
    }

    public static function getAllEmployees() {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT * FROM hs_hr_employee";
        $result = mysqli_query($dbc, $query) or die("Get employee from DB failed. " . mysqli_error($dbc));
        mysqli_close($dbc);

        $trainers = array();
        while ($row = mysqli_fetch_array($result)) {
            $trainer = array();
            array_push($trainer, $row['emp_number']);
            array_push($trainer, $row['employee_id']);
            array_push($trainer, $row['emp_firstname']);
            array_push($trainer, $row['emp_lastname']);
            array_push($trainers, $trainer);
        }
        return $trainers;
    }

}
?>

