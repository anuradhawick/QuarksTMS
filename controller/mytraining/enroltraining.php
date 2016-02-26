<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../API/training/LocalTraining.php';
require_once '../../API/employee/Employee.php';
require '../../API/traininghrm/TrainingHRMDBHandler.php';
require_once '../../API/logger/Logger.php';
$tr = new LocalTraining();
$emp = new Employee();

if (session_id() == '') {
    session_start();
}
$empNumber = $_SESSION['qis_emp'];

$emp->setEmpNumber($empNumber);
$idtraining = $_REQUEST['idtraining'];
$tr->setIdTraining($idtraining);
TrainingHRMDBHandler::enrollForTaining($emp, $tr);
$logger = Logger::getLogger();
$logger->enrollTraining();
echo json_encode(TRUE);
?>