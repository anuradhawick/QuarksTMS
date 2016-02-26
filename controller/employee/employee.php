<?php
/*
 * To handle employee object requests from the UI over json
 */
require_once '../../API/employee/DatabaseHandler/EmployeeDBHandler.php';
session_start();
$emp_number = $_SESSION['qis_emp'];
$emp = EmployeeDBHandler::getEmployeeById($emp_number);

echo json_encode($emp);
?>