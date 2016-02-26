<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../../API/traininghrm/TrainingHRMDBHandler.php';
$nic = $_GET['nic'];
echo json_encode(TrainingHRMDBHandler::getTrainingHistoryAsStringsByNIC($nic));

?>