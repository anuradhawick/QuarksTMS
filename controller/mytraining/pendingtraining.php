<?php

require_once 'DBClasses/TrainingDBHandler.php';
require_once 'Employee.php';

$emp_number = $_POST["emp_number"];
$employee = new Employee();
$employee->setEmpNumber($emp_number);

echo json_encode($trainingarray = TrainingDBHandler::getPendingTraining($employee));
?>
