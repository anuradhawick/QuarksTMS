<?php

/**
 * @author Dulaj Atapattu
 */
require_once '../../API/training/DBClasses/TrainingDBHandler.php';
require_once '../../API/traininghrm/TrainingHRMDBHandler.php';
if (session_id() == '') {
    session_start();
}

$emp_number = $_SESSION['qis_emp'];

/*
 *  Json format - date, name, type, authority
 */
echo json_encode(TrainingHRMDBHandler::getTrainingHistoryAsStrings($emp_number));

//print_r(TrainingHRMDBHandler::getTrainingHistoryAsStrings($emp_number));
?>