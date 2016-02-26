<?php

require_once '../../API/training/DBClasses/TrainingDBHandler.php';
require_once '../../API/training/Employee.php';
require_once '../../API/training/LocalTraining.php';
//id
$training = new LocalTraining();
$training->setIdTraining($_GET['id']);
$arr = TrainingDBHandler::getEnrolledEmployees($training);
$emp = new Employee();
$list = array();
foreach ($arr as $empl) {
    $emp = $empl;
    $item = array();
    array_push($item, $emp->getEmpNumber());
    array_push($item, $emp->getEmpNicNo());
    array_push($item, $emp->getEmpFirstname() . " " . $emp->getEmpLastname());
    array_push($list, $item);
}
echo json_encode($list);
?>