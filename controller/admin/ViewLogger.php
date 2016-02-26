<?php

/**
 * @author Dulaj Atapattu
 */
require_once '../../API/logger/LoggerDBHandler.php';

$from = $_POST['from'];
$to = $_POST['to'];
$emp_number = $_POST['emp_number'];
$iduse_case = $_POST['iduse_case'];
$from = $from . ' 00:00:00';
$to = $to . ' 00:00:00';

if (strlen($iduse_case) == 0) {
    $iduse_case = NULL;
}
if (strlen($emp_number) == 0) {
    $emp_number = NULL;
    echo json_encode(LoggerDBHandler::getActivityLogs($from, $to, $emp_number, $iduse_case));
} else {
    $emp_number = LoggerDBHandler::getEmpidFromEmpnumber($emp_number);
    if ($emp_number == -1) {
//        echo 'hehe';
        echo json_encode(array(array("", "No such user exists.", "")));
    } else {
        echo json_encode(LoggerDBHandler::getActivityLogs($from, $to, $emp_number, $iduse_case));
    }
}
?>