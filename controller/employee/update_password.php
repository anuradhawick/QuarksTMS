<?php

require_once './../../API/employee/Authenticator.php';
require_once '../../API/logger/Logger.php';
/*
  Check for the validity of the password
 */
$pass_new = $_POST['password'];
$pass_old = $_POST['currpwd'];
session_start();
$emp_number = $_SESSION['qis_emp'];
$auth = new Authenticator();
$success = $auth->changePassword($emp_number, $pass_old, $pass_new);
if ($success) {
    $logger = Logger::getLogger();
    $logger->updatePassword();
}
echo json_encode($success);
?>