<?php

require_once '../../API/employee/Employee.php';
require_once '../../API/employee/Authenticator.php';
require_once '../../API/logger/Logger.php';

$username = $_POST["username"];
$password = $_POST["password"];

/*
  Check for the login informationa and returns true if login success
  else returns false
 */
$auth = new Authenticator();
$login_success = $auth->SignIn($username, $password);
if (!($login_success === FALSE)) {
    session_start();
    $_SESSION['qis_logged'] = true;
    $_SESSION['qis_emp'] = $login_success;
    $logger = Logger::getLogger();
    $logger->signIn();
    echo json_encode(true);
} else {
    echo json_encode(false);
}
?>