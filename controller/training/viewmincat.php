<?php
//require_once 'DBClasses/TrainingDataDBHandler.php';
require_once '../../API/training/DBClasses/TrainingDataDBHandler.php';

$idmajor_category=$_GET["idmajor"];
echo json_encode(TrainingDataDBHandler::getMinorCategories($idmajor_category));
?>

