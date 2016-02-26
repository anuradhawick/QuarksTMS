<?php

/*
 * Coded by W.A.Anuradha Wickramarachchi
 * 
 * returns the list of all the Trainer objects available
 */

require_once '../../API/trainer/ExternalTrainer.php';
require_once '../../API/trainer/TrainerDBHandler.php';

$trainers = TrainerDBHandler::getExternalTrainers();

echo json_encode($trainers);
?>