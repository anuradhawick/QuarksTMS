<?php

/*
 * Coded by W.A.Anuradha Wickramarachchi
 */
require_once '../../API/employee/DatabaseHandler/EmployeeDBHandler.php';
$emps = EmployeeDBHandler::getAllEmployees();
echo json_encode($emps);
?>