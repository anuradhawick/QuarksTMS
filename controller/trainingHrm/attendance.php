<?php

require_once '../../API/training/Employee.php';
require_once '../../API/training/LocalTraining.php';
require_once '../../API/training/DBClasses/TrainingDBHandler.php';
$list = $_POST['list'];
$trainingId = $_POST['trainingId'];
$empArr = array();
foreach ($list as $empNumber) {
    $emp = new Employee();
    $emp->setEmpNumber($empNumber);
    array_push($empArr, $emp);
}
$training = new LocalTraining();
$training->setIdTraining($trainingId);
TrainingDBHandler::confirmEmployeeAttendance($training, $empArr);
echo json_encode(TRUE);
?>