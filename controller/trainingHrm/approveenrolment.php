<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../API/traininghrm/TrainingHRMDBHandler.php';
require_once '../../API/employee/Employee.php';
require_once '../../API/training/LocalTraining.php';
//Array
//(
//    [list] => Array
//        (
//            [0] => 1
//            [1] => 2
//            [2] => 3
//            [3] => 4
//            [4] => 5
//            [5] => 6
//        )
//
//    [trainingId] => 6
//)

$idtraining = $_POST['trainingId'];
$arr = $_POST['list'];
$emp = new Employee();
$tr = new LocalTraining();
$tr->setIdTraining($idtraining);
foreach ($arr as $id) {
    $emp->setEmpNumber($id);
    TrainingHRMDBHandler::respondToTraining($emp, $tr, 1);
}
require_once '../../API/logger/Logger.php';
$logger = Logger::getLogger();
$logger->respondToEnrollment();
echo json_encode(True);
?>