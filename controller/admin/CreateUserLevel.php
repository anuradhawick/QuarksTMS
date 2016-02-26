<?php

require_once dirname(__FILE__) . '/../../API/admin/AccessPrivilegeDBHandler.php';
require_once dirname(__FILE__) . '/../../API/admin/UserLevel.php';

$type = $_POST["type"];

$userlevel = new UserLevel();
$userlevel->setUserLevel_type($type);

AccessPrivilegeDBHandler::createUserLevel($userlevel);
require_once '../../API/logger/Logger.php';
$logger = Logger::getLogger();
$logger->addUserLevel();
echo json_encode(TRUE);
?>
