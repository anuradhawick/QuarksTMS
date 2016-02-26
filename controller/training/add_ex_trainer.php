<?php

/* 
 * Coded by W.A.Anuradha Wickramarachchi
 * 
 */

require_once '../../API/trainer/ExternalTrainer.php';
require_once '../../API/trainer/TrainerDBHandler.php';
$name = $_POST['name'];
$qual = $_POST['qual'];

$trainer = new ExternalTrainer();
$trainer->setName($name);
$trainer->setQualifications($qual);
TrainerDBHandler::addExternalTrainer($trainer);
echo json_encode(TRUE);
?>
