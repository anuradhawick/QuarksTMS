<?php

require_once '../../API/training/DBClasses/TrainingDBHandler.php';
require_once '../../API/employee/Employee.php';
if (session_id() == '') {
    session_start();
}
$emp_number = $_SESSION["qis_emp"];
$employee = new Employee();
$employee->setEmpNumber($emp_number);

echo json_encode($trainingarray = TrainingDBHandler::getEmployeeSelectedTraining($employee));
?>
