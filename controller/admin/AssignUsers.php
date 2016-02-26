<?php

require_once dirname(__FILE__) . '/../../API/admin/AccessPrivilegeDBHandler.php';
require_once dirname(__FILE__) . '/../../API/admin/UserLevel.php';

$userlevelid = $_POST["iduserlevel"];
$empids = $_POST["empids"];

print_r($_POST);
$userlevel = new UserLevel();
$userlevel->setUserLevel_ID($userlevelid);
$emp_array = array();
foreach ($empids as $empid) {
    $employee = new Employee();
    $employee->setEmpNumber($empid);
    array_push($emp_array, $employee);
}

AccessPrivilegeDBHandler::assignUsers($userlevel, $emp_array);
require_once '../../API/logger/Logger.php';
$logger = Logger::getLogger();
$logger->addUserToUserLevel();
echo json_encode(TRUE);
?>

