<?php

/*
 * ***** Coded by D. R. ATAPATTU *****
 */


require_once dirname(__FILE__).'/../Constants/DatabaseCredentials.php';

class LoggerDBHandler {

    private $idlogin_sessions;

    public function __construct() {
        
    }

    public function startLogSession($emp_number) {

        $timestamp = date('Y-m-d H:i:s');
        $ip_address = $_SERVER['SERVER_ADDR'];

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "INSERT INTO login_sessions (emp_number, in_time, ip_address) VALUES ('$emp_number','$timestamp','$ip_address')";
        mysqli_query($dbc, $query) or die("Add new logging session failed. " . mysqli_error($dbc));
        $this->idlogin_sessions = mysqli_insert_id($dbc);
        mysqli_close($dbc);
    }

    public function endLogSession() {

        $timestamp = date('Y-m-d H:i:s');
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "UPDATE login_sessions set out_time='$timestamp' WHERE idlogin_sessions='$this->idlogin_sessions'";
        mysqli_query($dbc, $query) or die("End current logging session failed. " . mysqli_error($dbc));
        mysqli_close($dbc);
    }

    public function addLog($iduse_case, $activity) {
//      Create connection
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

//      Check connection
        if ($conn->connect_error) {
            die("Database connection failed. " . $conn->connect_error);
        }

//      Prepare and bind
        $stmt = $conn->prepare("INSERT INTO session_activities (idlogin_sessions, time, iduse_case, activity) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $this->idlogin_sessions, date('Y-m-d H:i:s'), $iduse_case, $activity);

//      Set parameters and execute
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    public static function getActivityLogs($from, $to, $emp_number, $iduse_case) {
        $logsArray = array();
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));

        if ($emp_number === NULL && $iduse_case === NULL) {
            $query = "SELECT `time`, employee_id, activity FROM login_sessions JOIN session_activities on login_sessions.idlogin_sessions=session_activities.idlogin_sessions JOIN hs_hr_employee on hs_hr_employee.emp_number=login_sessions.emp_number WHERE `time`>'$from' AND `time`<'$to' ORDER BY `time` ;";
        } elseif ($iduse_case === NULL) {
            $query = "SELECT `time`, employee_id, activity FROM login_sessions JOIN session_activities on login_sessions.idlogin_sessions=session_activities.idlogin_sessions JOIN hs_hr_employee on hs_hr_employee.emp_number=login_sessions.emp_number WHERE `time`>'$from' AND `time`<'$to' AND hs_hr_employee.emp_number='$emp_number' ORDER BY `time` DESC;";
        } elseif ($emp_number === NULL) {
            $query = "SELECT `time`, employee_id, activity FROM login_sessions JOIN session_activities on login_sessions.idlogin_sessions=session_activities.idlogin_sessions JOIN hs_hr_employee on hs_hr_employee.emp_number=login_sessions.emp_number WHERE `time`>'$from' AND `time`<'$to' AND session_activities.iduse_case=$iduse_case ORDER BY `time` DESC;";
        } else {
            $query = "SELECT `time`, employee_id, activity FROM login_sessions JOIN session_activities on login_sessions.idlogin_sessions=session_activities.idlogin_sessions JOIN hs_hr_employee on hs_hr_employee.emp_number=login_sessions.emp_number WHERE `time`>'$from' AND `time`<'$to' AND hs_hr_employee.emp_number='$emp_number' AND session_activities.iduse_case='$iduse_case' ORDER BY `time` DESC;";
        }

        $result = mysqli_query($dbc, $query) or die("Get all records from DB failed. " . mysqli_error($dbc));
        mysqli_close($dbc);
        while ($row = mysqli_fetch_row($result)) {
            array_push($logsArray, array($row[0], $row[1], $row[2]));
        }
        return $logsArray;
    }

    public static function getEmpidFromEmpnumber($emp_number) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Database connection failed. " . mysqli_error($dbc));
        $query = "SELECT `emp_number` FROM `hs_hr_employee` WHERE `employee_id`='$emp_number';";
        $result = mysqli_query($dbc, $query) or die("Get empnumber failed. " . mysqli_error($dbc));
        mysqli_close($dbc);
        $row = mysqli_fetch_array($result);

        if (empty($row)) {
            return -1;
        } else {
            return $row['emp_number'];
        }
    }

}

?>