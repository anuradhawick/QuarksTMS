<?php  
require_once '../../API/employee/DatabaseHandler/EmployeeDBHandler.php';
$nic = $_GET['nic'];
$search_result = EmployeeDBHandler::searchEmployeeById($nic);

echo json_encode($search_result);
?>