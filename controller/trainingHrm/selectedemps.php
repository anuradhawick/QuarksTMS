<?php

require_once '../../API/training/DBClasses/TrainingDBHandler.php';
require_once '../../API/training/LocalTraining.php';


$idtraining = $_GET["idtraining"];

$training = new LocalTraining();
$training->setIdTraining($idtraining);

echo json_encode(TrainingDBHandler::viewSelectedEmployees($training));
?>