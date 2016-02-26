<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once '../../API/admin/AccessPrivilegeDBHandler.php';
$id = $_REQUEST['id'];
$array = AccessPrivilegeDBHandler::getUseCasesByLevel($id);
echo json_encode($array);
?>
