<?php

require_once './../../API/employee/Authenticator.php';
$auth = new Authenticator();
$employee_id = $_POST['nic'];
$success = $auth->isUserExists($employee_id);
if ($success === FALSE) {
    echo json_encode(FALSE);
    return;
} else {
    $auth->addUser($success, $employee_id);
    echo json_encode(TRUE);
}
?>