<?php

/*
  use the emp_number to get post the training request
 */

/*
 * foreign = 0
 * local = 1
 * in-house = 2
 */

require_once './../../API/training/DBClasses/TrainingDBHandler.php';
require_once './../../API/training/TrainingRequest.php';
require_once '../../API/logger/Logger.php';
$subject = $_GET['subject'];
$type = $_GET['type'];
$description = $_GET['description'];
$importance = $_GET['importance'];
session_start();
$emp_number = $_SESSION['qis_emp'];
$training_request = TrainingRequest::withRow($emp_number, $subject, $type, $description, $importance);
TrainingDBHandler::addTrainingRequest($training_request);
$logger = Logger::getLogger();
$logger->requestNewTraining();
echo json_encode(TRUE);
// echo $subject . "___" . $type . "__" . $description . "__" . $importance;
?>