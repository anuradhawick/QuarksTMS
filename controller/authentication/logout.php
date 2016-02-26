<?php
require_once '../../API/logger/Logger.php';
$logger = Logger::getLogger();
$logger->signOut();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
session_unset();
session_destroy();

echo json_encode(true);
?>