<?php

/**
 * @author Dulaj Atapattu
 */

require_once '../../API/employee/DatabaseHandler/TrainingHRMDBHandler.php';
$emp_number=$_POST['emp_number'];
//$emp_number = 0;

/*
 * Parameter order of return array
 * *** training name, foreign/local/inhouse, conducting_authority, level of training, minor category, program type, trainer type, trainer name, triner qualification, clocing date, no of participantes, trainee requirements, other details
 */
echo json_encode(TrainingHRMDBHandler::getUpComingTraining($emp_number));
?>
